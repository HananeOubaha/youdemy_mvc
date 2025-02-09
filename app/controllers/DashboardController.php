<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../models/Teacher.php";
require_once __DIR__ . "/../models/Admin.php";

class DashboardController
{
    private $db;

    public function __construct()
    {
        $database = Database::getInstance();
        $this->db = $database->getConnection();

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function index()
    {
        $role = $_SESSION['role'] ?? '';
        $is_verified = $_SESSION['is_verified'] ?? false;

        if ($role === 'teacher' && !$is_verified) {
            header('Location: /auth/waiting-for-verification');
            exit;
        }

        switch ($role) {
            case 'admin':
                $this->adminDashboard();
                break;
            case 'teacher':
                $this->teacherDashboard();
                break;
            case 'student':
                $this->studentDashboard();
                break;
            default:
                header('Location: /auth/login');
                exit;
        }
    }

    // Rendre ces méthodes publiques
    public function adminDashboard()
    {
        require_once __DIR__ . "/../views/dashboard/admin.php";
    }

    public function teacherDashboard()
    {
        require_once __DIR__ . "/../views/dashboard/teacher.php";
    }

    public function studentDashboard()
    {
        require_once __DIR__ . "/../views/dashboard/student.php";
    }
}