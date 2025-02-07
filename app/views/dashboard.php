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

    <?php include '../pages/footer.php'; ?>

</body>
</html>
