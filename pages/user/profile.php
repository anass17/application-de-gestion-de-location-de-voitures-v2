<?php
    session_start();

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    $conn = (new Database) -> connect();

    $user = new User($conn);
    $user -> fetchById($_SESSION['id']);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $phone = $_POST["phone"];

        $user -> setUsername($username);
        $user -> setEmail($email);
        $user -> setAddress($address);
        $user -> setPhoneN($phone);

        if ($user -> update()) {
            header('Location: profile.php');
            exit;
        } else {
            $error = "Error! Could not update your information";
        }

    }

    $attr = 'disabled';
    $classes = "appearance-none border border-transparent rounded w-full py-2 px-3";
    $edit = false;

    if (isset($_GET['edit']) && $_GET['edit'] == "true") {
        $edit = true;
        $attr = '';
        $classes = "shadow border appearance-none rounded w-full py-2 px-3";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-gray-700 text-center mb-6">Profile</h1>
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 max-w-lg mx-auto">
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 p-3 text-center rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <div class="mb-4">
                <label class="block text-gray-700" for="username">Username:</label>
                <!-- <input type="text" name="make" class="shadow appearance-none border rounded w-full py-2 px-3" value=""> -->
                <input type="text" name="username" id="username" class="<?php echo $classes; ?>" <?php echo $attr; ?> value="<?php echo $user -> getUsername(); ?>" placeholder="Enter a username">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email:</label>
                <input type="text" name="email" id="email" class="<?php echo $classes; ?>" <?php echo $attr; ?> value="<?php echo $user -> getEmail(); ?>" placeholder="Enter an email">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="address">Address:</label>
                <input type="text" name="address" id="address" class="<?php echo $classes; ?>" <?php echo $attr; ?> value="<?php echo $user -> getAddress(); ?>" placeholder="Enter an address">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="phone">Phone Number:</label>
                <input type="text" name="phone" id="phone" class="<?php echo $classes; ?>" <?php echo $attr; ?> value="<?php echo $user -> getPhoneN(); ?>" placeholder="Enter a phone number">
            </div>
            <div class="text-center mt-7">
                <?php if($edit == false): ?>
                    <a href="profile.php?edit=true" class="bg-blue-500 text-white w-24 py-2 rounded hover:bg-blue-600 inline-block">Edit</a>
                <?php else: ?>
                    <button type="submit" class="bg-blue-500 text-white w-24 py-2 rounded hover:bg-blue-600 inline-block mr-2">Save</button>
                    <a href="profile.php" class="bg-gray-500 text-white w-24 py-2 rounded hover:bg-gray-600 inline-block">Cancel</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>