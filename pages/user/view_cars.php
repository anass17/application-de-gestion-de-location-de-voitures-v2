<?php
    session_start();

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';
    require '../class/CarClass.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    $conn = (new Database) -> connect();

    $user = new User($conn);
    $user -> fetchById($_SESSION['id']);

    $car = new Car($conn, $user);

    $result = $car -> readAll()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cars</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-gray-700 text-center mb-6">Cars List</h1>
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-md rounded border border-gray-300 text-center">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Make</th>
                        <th class="px-4 py-2">Model</th>
                        <th class="px-4 py-2">Year</th>
                        <th class="px-4 py-2">License Plate</th>
                        <th class="px-4 py-2">Status</th>
                        <?php if ($user -> getRole() == 'admin'): ?>
                            <th class="px-4 py-2">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $row): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-2"><?= $row['id'] ?></td>
                            <td class="px-4 py-2"><?= $row['make'] ?></td>
                            <td class="px-4 py-2"><?= $row['model'] ?></td>
                            <td class="px-4 py-2"><?= $row['year'] ?></td>
                            <td class="px-4 py-2"><?= $row['license_plate'] ?></td>
                            <td class="px-4 py-2"><?= $row['status'] ?></td>
                            <?php if ($user -> getRole() == 'admin'): ?>
                                <td class="px-4 py-2">
                                    <a href="../admin/edit_car.php?id=<?= $row['id'] ?>" class="bg-blue-500 text-white w-24 py-2 rounded hover:bg-blue-600 inline-block border text-center mr-2">Edit</a>
                                    <a href='/pages/admin/delete_car.php?id=<?php echo $row['id']; ?>' class='bg-red-500 text-white w-24 py-2 rounded hover:bg-red-600 inline-block border text-center'>Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
