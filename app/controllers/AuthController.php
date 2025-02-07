<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../models/Teacher.php";
require_once __DIR__ . "/../models/Admin.php";


class AuthController
{
    function index()
    {
      require_once __DIR__."/../views/auth/login.php";
    }
    function Register()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $database = Database::getInstance();
        $db = $database->getConnection();

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($role)) {
                $error = 'All fields are required';
            } else {
                try {
                    switch ($role) {
                        case 'student':
                            $user = new Student($db);
                            break;
                        case 'teacher':
                            $user = new Teacher($db);
                            break;
                        case 'admin':
                            $user = new Admin($db);
                            break;
                        default:
                            $error = 'Invalid role selected';
                            break;
                    }

                    if (isset($user)) {
                        if ($user->register($username, $email, $password, $role)) {
                            $success = 'Registration successful! Please login.';
                        } else {
                            $error = 'Registration failed';
                        }
                    }
                } catch (PDOException $e) {
                    $error = 'Email or username already exists';
                }
            }
        }

        // Inclure la vue tout en passant les variables d'erreur et de succès
        
        require_once __DIR__ . "/../views/auth/register.php";
    }
    // Gère la connexion de l'utilisateur
    public function login()
    {
        session_start();
        require_once __DIR__ . '/../config/config.php';

        $database = Database::getInstance();
        $db = $database->getConnection();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $query = "SELECT id, role, password, is_verified FROM users WHERE email = :email AND is_active = TRUE";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['is_verified'] = $row['is_verified'];

                    // Rediriger vers le tableau de bord après connexion
                    header('Location: /views/dashboard.php');
                    exit;
                } else {
                    $error = 'Invalid email or password';
                }
            } else {
                $error = 'Invalid email or password';
            }
        }

        // Afficher la page de connexion avec un message d'erreur
        require __DIR__ . "/../views/auth/login.php";
    }
}
