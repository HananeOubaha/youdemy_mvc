<?php
require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../models/User.php";
require_once __DIR__ . "/../../models/CourseText.php";
require_once __DIR__ . "/../../models/CourseVideo.php";

$courseText = new CourseText($this->db);
$courseVideo = new CourseVideo($this->db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-indigo-800 to-purple-800 shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-7">
                    <div>
                        <a href="/" class="flex items-center py-4 px-2">
                            <span class="font-semibold text-white text-2xl">Youdemy</span>
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="/auth/logout" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-8">Welcome to Your Dashboard, Admin!</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- User Management -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-center">
                    <i class="fas fa-users text-5xl text-blue-500 mb-4"></i>
                    <h2 class="text-xl font-semibold mb-4">User Management</h2>
                    <a href="/admin/users" class="text-blue-500 hover:text-blue-700">Manage Users →</a>
                </div>
            </div>

            <!-- Category Management -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-center">
                    <i class="fas fa-tags text-5xl text-purple-500 mb-4"></i>
                    <h2 class="text-xl font-semibold mb-4">Category Management</h2>
                    <a href="/admin/categories" class="text-blue-500 hover:text-blue-700">Manage Categories →</a>
                </div>
            </div>

            <!-- Course Validation -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-center">
                    <i class="fas fa-book text-5xl text-green-500 mb-4"></i>
                    <h2 class="text-xl font-semibold mb-4">Course Validation</h2>
                    <a href="/admin/validate-courses" class="text-blue-500 hover:text-blue-700">Validate Courses →</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>