<?php
    include '../../inc/session_activity.php';

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
    $users_result = $user -> fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Clients</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <!-- View Clients Content -->
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Users List</h1>
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-gray-600 text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Phone Number</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Role</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <?php if (count($users_result) > 0): ?>
                    <?php foreach ($users_result as $row): ?>
                        <tr class='border-b border-gray-200 hover:bg-gray-100'>
                            <td class='py-3 px-6 text-left'><?php echo $row['id']; ?></td>
                            <td class='py-3 px-6 text-left'><?php echo $row['username']; ?></td>
                            <td class='py-3 px-6 text-left'><?php echo $row['Address']; ?></td>
                            <td class='py-3 px-6 text-left'><?php echo $row['phoneN']; ?></td>
                            <td class='py-3 px-6 text-left'><?php echo $row['email']; ?></td>
                            <td class='py-3 px-6 text-left'><?php echo $row['role']; ?></td>
                            <td class='py-3 px-6 text-center'>
                                <?php if ($row['role'] == 'user'): ?>
                                    <a href='delete_user.php?id=<?php echo $row['id']; ?>' class='bg-red-500 text-white w-24 py-2 rounded hover:bg-red-600 inline-block border'>Delete</a>
                                <?php else: ?>
                                    <button class='bg-gray-100 w-24 py-2 rounded inline-block border'>No Actions</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                        <tr><td colspan='6' class='py-3 px-6 text-center'>No clients found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<script src="viewC.js"></script>
</body>
</html>
