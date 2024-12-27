<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: auth/login.php");
        exit();
    }

    require_once 'vendor/autoload.php';
    require 'connection/db.php';
    require 'auth/UserClass.php';

    $conn = (new Database) -> connect();

    $user = new User($conn);

    $user -> fetchById($_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 text-center">Welcome, <?php echo htmlspecialchars($user -> getUsername()); ?>!</h1>
        <p class="text-center mt-4">You are now logged in. Use the navigation bar to explore the application.</p>
    </div>
</body>
</html>
