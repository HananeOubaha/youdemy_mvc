<?php
// app/controllers/AuthController.php

require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../models/Student.php";
require_once __DIR__ . "/../models/Teacher.php";
require_once __DIR__ . "/../models/Admin.php";

class AuthController
{
    private $userModel;

    public function __construct() {
        $database = Database::getInstance();
        $db = $database->getConnection();
        $this->userModel = new UserModel($db);
    }

    public function index()
    {
        require_once __DIR__."/../views/auth/login.php";
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Déterminer la classe à utiliser en fonction du rôle
                $role = $user['role'];
                switch ($role) {
                    case 'student':
                        $userObj = new Student($this->userModel->db);
                        break;
                    case 'teacher':
                        $userObj = new Teacher($this->userModel->db);
                        break;
                    case 'admin':
                        $userObj = new Admin($this->userModel->db);
                        break;
                    default:
                        $error = 'Invalid role';
                        break;
                }

                if (isset($userObj)) {
                    // Stocker les informations de l'utilisateur dans la session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $role;
                    $_SESSION['is_verified'] = $user['is_verified'];

                    // Rediriger vers le tableau de bord unique
                    header('Location: ' . HOST . '/dashboard');
                    exit;
                }
            } else {
                $error = 'Invalid email or password';
            }
        }

        // Si on arrive ici, c'est qu'il y a eu une erreur
        $this->index();
    }

    public function register()
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

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . HOST . '/auth/login');
        exit;
    }
}
