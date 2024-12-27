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

    if (isset($_GET['id'])) {
        $carId = $_GET['id'];

        $conn = (new Database) -> connect();

        $user = new User($conn);
        $user -> fetchById($_SESSION['id']);

        $car = new Car($conn, $user);

        $result = $car -> getById($carId);
    } else {
        header('Location: ../user/view_cars.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = (new Database) -> connect();

        $make = $_POST['make'];
        $model = $_POST['model'];
        $year = $_POST['year'];
        $license_plate = $_POST['license_plate'];
        $status = $_POST['status'];

        $sql = "UPDATE cars SET make = :make, model = :model, year = :year, 
                license_plate = :license, status = :status WHERE id = :id";

        $stmt = $conn -> prepare($sql);
        $isExecuted = $stmt -> execute(array(
            ':make' => $make,
            ':model' => $model,
            ':year' => $year,
            ':license' => $license_plate,
            ':status' => $status,
            ':id' => $carId
        ));

        if ($isExecuted == true) {
            header('Location: ../user/view_cars.php');
            exit();
        } else {
            echo 'Error';
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
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
        </ul>
    </nav>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 mb-6 text-center">Edit Car</h1>
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 max-w-lg mx-auto">
    <div class="mb-4">
        <label class="block text-gray-700">Make:</label>
        <input type="text" name="make" value="<?php echo htmlspecialchars($result['make']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Model:</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($result['model']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Year:</label>
        <input type="number" name="year" value="<?php echo htmlspecialchars($result['year']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">License Plate:</label>
        <input type="text" name="license_plate" value="<?php echo htmlspecialchars($result['license_plate']); ?>" required class="shadow appearance-none border rounded w-full py-2 px-3">
    </div>
    <div class="mb-4">
        <label class="block text-gray-700">Status:</label>
        <select name="status" class="shadow appearance-none border rounded w-full py-2 px-3">
            <option  value="Available" <?php echo ($result['status'] == 'Available') ? 'selected' : ''; ?>>Available</option>
            <option value="Rented" <?php echo ($result['status'] == 'Rented') ? 'selected' : ''; ?>>Rented</option>
            <option value="Maintenance" <?php echo ($result['status'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
        </select>
    </div>
    <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Car</button>
        <a href="view_cars.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
    </div>
</form>

    </div>
</body>
</html>