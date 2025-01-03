<?php

session_start();

if (isset($_SESSION['id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../vendor/autoload.php';
require "../connection/db.php";
require '../pages/class/ValidatorClass.php';
require 'UserClass.php';

$conn = (new Database()) -> connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $validator = new Validator($_POST['email'], $_POST['password'], $_POST['username'], $_POST['confirm_password']);

    // Verify Input data

    if ($validator -> verifyRegister()) {

        $user = new User($conn);

        // Register new user

        if ($user -> register($_POST["username"], $_POST["email"], $_POST["password"]) === true) {
            $_SESSION["id"] = $user -> getId();
            header('Location: ../index.php');
            exit;
        } else {
            $error = $user -> error;
        }

    } else {
        $error = $validator -> error;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h1 class="text-2xl font-bold mb-4">Register</h1>
        <?php if (isset($error)): ?>
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Username:</label>
                <input type="text" name="username" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email:</label>
                <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password:</label>
                <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Confirm Password:</label>
                <input type="password" name="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <a href="login.php" class="font-semibold text-blue-500 mb-5 block">You have an account?</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">Register</button>
        </form>
    </div>
</body>
</html>
