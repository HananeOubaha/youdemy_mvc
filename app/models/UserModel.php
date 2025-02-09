<?php
// app/models/UserModel.php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByEmail($email) {
        $query = "SELECT id, role, password, is_verified FROM users WHERE email = :email AND is_active = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}