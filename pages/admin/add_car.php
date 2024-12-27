<?php
    session_start();

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';                    // Include database connection
    require '../../auth/UserClass.php';
    require '../class/CarClass.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $conn = (new Database) -> connect();

        $user = new User($conn);
        $user -> fetchById($_SESSION['id']);

        $car = new Car($conn, $user);

        $car -> setMake($_POST['make']);
        $car -> setModel($_POST['model']);
        $car -> setYear($_POST['year']);
        $car -> setLicensePlate($_POST['license_plate']);
        $car -> setStatus($_POST['status']);

        if ($car -> create()) {
            header('Location: ../user/view_car.php');
            exit;
        } else {
            $error = $car -> error;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar Section -->
    <nav class="bg-blue-600 text-white p-4 shadow">
        <ul class="flex justify-around">
            <li><a href="adduser.html" class="hover:text-gray-200">Add Client</a></li>
            <li><a href="view_clients.php" class="hover:text-gray-200">View Clients</a></li>
            <li><a href="view_cars.php" class="hover:text-gray-200">View Cars</a></li>
            <li><a href="add_car.php" class="hover:text-gray-200">Add Cars</a></li>
            <li><a href="add_rental_contract.php" class="hover:text-gray-200">Add Rental Contracts</a></li>
            <li><a href="add_rental_contract.php" class="hover:text-gray-200">Add Rental Contract</a></li>
            <li><a href="view_rental_contracts.php" class="hover:text-gray-200">View Rental Contracts</a></li>
            <li><a href="../../auth/logout.php" class="hover:text-gray-200">Logout</a></li>
        </ul>
    </nav>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 mb-6 text-center">Add a New Car</h1>
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 max-w-lg mx-auto">
            <div class="mb-4">
                <label class="block text-gray-700">Make:</label>
                <input type="text" name="make" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Model:</label>
                <input type="text" name="model" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Year:</label>
                <input type="number" name="year" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">License Plate:</label>
                <input type="text" name="license_plate" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Status:</label>
                <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3">
                    <option value="Available">Available</option>
                    <option value="Rented">Rented</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Car</button>
                <a href="view_cars.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
