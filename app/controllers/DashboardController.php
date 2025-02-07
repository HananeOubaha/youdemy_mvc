<?php
require_once '../config/config.php';
require_once '../models/User.php';
require_once '../models/CourseText.php';
require_once '../models/CourseVideo.php';

class DashboardController {
    public function index() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ../public/login.php');
            exit;
        }

        $database = Database::getInstance();
        $db = $database->getConnection();

        $role = $_SESSION['role'];
        $is_verified = $_SESSION['is_verified'] ?? false; 

        // Redirection si l'enseignant n'est pas vérifié
        if ($role === 'teacher' && !$is_verified) {
            header("Location: ../public/waiting-for-verification.php");
            exit();
        }

        // Charger la vue et passer les données
        include '../views/dashboard.php';
    }
}
