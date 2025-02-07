<?php
abstract class User {
    protected $db;
    protected $id;
    protected $username;
    protected $email;
    protected $passwordHash;
    protected $role;
    protected $isActive;
    protected $isVerified;
    protected $createdAt;

    public function __construct($db, $id = null, $username = null, $email = null, $passwordHash = null, $role = null, $isActive = null, $isVerified = null, $createdAt = null) {
        $this->db = $db;
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
        $this->isActive = $isActive;
        $this->isVerified = $isVerified;
        $this->createdAt = $createdAt;
    }

    public function getId() { return $this->id; }
    public function getUsername() { return $this->username; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getIsActive() { return $this->isActive; }
    public function getIsVerified() { return $this->isVerified; }
    public function getCreatedAt() { return $this->createdAt; }

    public function setUsername($username) { $this->username = $username; }
    public function setEmail($email) { $this->email = $email; }
    public function setRole($role) { $this->role = $role; }
    public function setIsActive($isActive) { $this->isActive = $isActive; }
    public function setIsVerified($isVerified) { $this->isVerified = $isVerified; }

    protected function setPasswordHash($password) {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    // Méthode pour vérifier si l'email existe déjà dans la base de données
    private function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    abstract public function login($email, $password);

    // Mise à jour de la méthode register pour inclure la vérification de l'email
    public function register($username, $email, $password, $role) {
        // Vérifier si l'email existe déjà
        if ($this->emailExists($email)) {
            throw new Exception("Email already exists.");
        }

        // Hacher le mot de passe
        $this->setPasswordHash($password);

        // Insérer l'utilisateur
        $query = "INSERT INTO users (username, email, password, role, is_active, is_verified, created_at) 
                  VALUES (:username, :email, :password, :role, :is_active, :is_verified, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':is_active', true, PDO::PARAM_BOOL); // Actif par défaut
        $stmt->bindValue(':is_verified', false, PDO::PARAM_BOOL); // Non vérifié par défaut
        $stmt->execute();

        // Récupérer l'ID du nouvel utilisateur
        $this->id = $this->db->lastInsertId();
    }

    public function logout() {
        session_start();
        session_destroy();
    }

    public function save() {
        try {
            if ($this->id) {
                // Update user
                $query = "UPDATE users SET username = :username, email = :email, password = :password, 
                          role = :role, is_active = :is_active, is_verified = :is_verified 
                          WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            } else {
                // Insert new user
                $query = "INSERT INTO users (username, email, password, role, is_active, is_verified, created_at) 
                          VALUES (:username, :email, :password, :role, :is_active, :is_verified, NOW())";
                $stmt = $this->db->prepare($query);
            }
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->passwordHash, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
            $stmt->bindParam(':is_active', $this->isActive, PDO::PARAM_BOOL);
            $stmt->bindParam(':is_verified', $this->isVerified, PDO::PARAM_BOOL);
            $stmt->execute();

            // Récupérer l'ID si c'est une nouvelle insertion
            if (!$this->id) {
                $this->id = $this->db->lastInsertId();
            }
            return $this->id;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new Exception("An error occurred while saving the user.");
        }
    }
}
?>
