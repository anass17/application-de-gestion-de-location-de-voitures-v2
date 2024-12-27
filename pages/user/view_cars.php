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
    <nav class="bg-blue-600 text-white p-4 shadow">
        <ul class="flex justify-around">
            <li><a href="adduser.html" class="hover:text-gray-200">Add Client</a></li>
            <li><a href="view_clients.php" class="hover:text-gray-200">View Clients</a></li>
            <li><a href="add_car.php" class="hover:text-gray-200">Add Cars</a></li>
            <li><a href="../user/view_cars.php" class="hover:text-gray-200">View Cars</a></li>
            <li><a href="add_rental_contract.php" class="hover:text-gray-200">Add Rental Contracts</a></li>
            <li><a href="view_rental_contracts.php" class="hover:text-gray-200">View Rental Contracts</a></li>
            <li><a href="../../auth/logout.php" class="hover:text-gray-200">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-gray-700 text-center mb-6">Cars List</h1>
        <div class="overflow-x-auto">
            <table class="table-auto w-full bg-white shadow-md rounded border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Make</th>
                        <th class="px-4 py-2 text-left">Model</th>
                        <th class="px-4 py-2 text-left">Year</th>
                        <th class="px-4 py-2 text-left">License Plate</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Actions</th>
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
                            <td class="px-4 py-2">
                                <a href="../admin/edit_car.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a> | 
                                <a href="../admin/delete_car.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
