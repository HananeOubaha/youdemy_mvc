<?php
// Démarrer la session uniquement si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/url.php';

// Récupérer les messages d'erreur et de succès de la session
$error = $_SESSION['error'] ?? '';
$success = $_SESSION['success'] ?? '';

// Supprimer les messages de la session après les avoir récupérés
unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <div class="hidden lg:block w-1/2 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1951&q=80');">
            <div class="h-full bg-black bg-opacity-50 flex items-center justify-center">
                <div class="text-white text-center p-8">
                    <h1 class="text-5xl font-bold mb-4">Join Youdemy</h1>
                    <p class="text-xl">Start your learning journey today.</p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-blue-50 to-purple-50">
            <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-md transform transition-all duration-500 hover:scale-105">
                <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Create Account</h1>
                
                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate-fade-in">
                        <?= htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 animate-fade-in">
                        <?= htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= HOST ?>/AuthController/Register">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                            <i class="fas fa-user mr-2"></i>Username
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                               id="username" type="text" name="username" required placeholder="Enter your username">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                               id="email" type="email" name="email" required placeholder="Enter your email">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                               id="password" type="password" name="password" required placeholder="Enter your password">
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                            <i class="fas fa-user-tag mr-2"></i>Role
                        </label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500"
                                id="role" name="role" required>
                            <option value="">Select a role</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 w-full transition duration-300 transform hover:scale-105"
                                type="submit">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </button>
                    </div>
                </form>

                <p class="text-center mt-4 text-gray-600">
                    Already have an account? <a href="<?= HOST ?>/views/auth/login" class="text-blue-500 hover:text-blue-700 font-semibold">Login</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html> 