<!-- app/views/partials/nav.php -->
<nav class="bg-gradient-to-r from-indigo-800 to-purple-800 shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between">
            <div class="flex space-x-7">
                <div>
                    <a href="<?php echo HOST; ?>" class="flex items-center py-4 px-2">
                        <span class="font-semibold text-white text-2xl">Youdemy</span>
                    </a>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo HOST; ?>/auth/logout" class="py-2 px-4 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>