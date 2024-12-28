<?php
    session_start();

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';
    require '../class/carClass.php';
    require '../class/RentalContractClass.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    $conn = (new Database) -> connect();

    $user = new User($conn);
    $user -> fetchById($_SESSION['id']);

    $car = new Car($conn, $user);

    $cars_list = $car -> readAll();
    
    $contract = new RentalContract($conn, $user);


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $car_id = $_POST['car_id'];
        $rental_date = $_POST['rental_date'];
        $return_date = $_POST['return_date'];


        $contract -> setCarId($car_id);
        $contract -> setRentalDate($rental_date);
        $contract -> setReturnDate($return_date);
        $contract -> setTotalAmount(0);
        
        $isInserted = $contract -> create();

        if ($isInserted) {
            header("Location: view_my_rental_contracts.php");
            exit;
        } else {
            echo 'Error';
        }


    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Rental Contract</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">Add Rental Contract</h1>

        <!-- Rental Contract Form -->
        <form action="add_rental_contract.php" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 max-w-lg mx-auto">

            <div class="mb-4">
                <label for="car_id" class="block text-gray-700 text-sm font-bold mb-2">Car:</label>
                <select name="car_id" id="car_id" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select Car</option>
                    <?php
                        foreach ($cars_list as $car) {
                            echo "<option value='{$car['id']}'> {$car['make']} - {$car['model']} </option>";
                        }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rental_date" class="block text-gray-700 text-sm font-bold mb-2">Rental Date:</label>
                <input type="date" name="rental_date" id="rental_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-10">
                <label for="return_date" class="block text-gray-700 text-sm font-bold mb-2">Return Date:</label>
                <input type="date" name="return_date" id="return_date" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Rental Contract</button>
                <a href="view_rental_contracts.php" required class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>