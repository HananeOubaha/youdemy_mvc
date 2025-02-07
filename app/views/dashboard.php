<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/auth/login.php'); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit;
}

// Récupération du rôle de l'utilisateur depuis la session
$role = $_SESSION['role'] ?? 'student'; // Défaut à "student" si le rôle n'est pas défini
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <?php include '../pages/navbar.php'; ?>

    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Welcome to Your Dashboard</h1>

        <?php if ($role === 'admin'): ?>
            <?php include '../views/admin-dashboard.php'; ?>
        <?php elseif ($role === 'teacher'): ?>
            <?php include '../views/teacher-dashboard.php'; ?>
        <?php else: ?>
            <?php include '../views/student-dashboard.php'; ?>
        <?php endif; ?>
    </div>

    <?php include '../layouts/views/footer.php'; ?>

</body>
</html>
