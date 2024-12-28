<?php

    include '../../inc/session_activity.php';

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';
    require '../class/carClass.php';
    require '../class/RentalContractClass.php';

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    if (isset($_GET['id'])) {
        $contract_id = $_GET['id'];
        $conn = (new Database) -> connect();

        $user = new User($conn);

        $contract = new RentalContract($conn, $user);
        $contracts_result = $contract -> read($contract_id);

        $user -> fetchById($contracts_result['ID_user']);

        if (!$contracts_result) {
            header("Location: view_rental_contracts.php");
            exit();
        }

        $car = new Car($conn, $user);
        $cars_result = $car -> readAll();

    } else {
        header("Location: view_rental_contracts.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $carId = $_POST['car_id'];
        $rentalDate = $_POST['rental_date'];
        $returnDate = $_POST['return_date'];

        $contract -> setCarId($carId);
        $contract -> setRentalDate($rentalDate);
        $contract -> setReturnDate($returnDate);
        $contract -> update();

        header('Location: view_rental_contracts.php');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rental Contract</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <!-- Edit Rental Contract Form -->
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">Edit Rental Contract</h1>

        <form action="edit_rental_contract.php?id=<?php echo $contract_id; ?>" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 max-w-lg mx-auto">
            <div class="mb-4">
                <label for="client_id" class="block text-gray-700 text-sm font-bold mb-2">Client:</label>
                <input type="text" name="client_id" class="appearance-none rounded w-full py-2 px-3" value="<?php echo $user -> getUsername(); ?>" disabled>
            </div>

            <div class="mb-4">
                <label for="car_id" class="block text-gray-700 text-sm font-bold mb-2">Car:</label>
                <select name="car_id" id="car_id" class="shadow appearance-none border rounded w-full py-2 px-3">
                    <?php foreach ($cars_result as $row): ?>
                        <option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $contracts_result['car_id']) ? 'selected' : ''; ?>>
                            <?php echo $row['make'] . ' ' . $row['model']; ?>
                            dsdf
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="rental_date" class="block text-gray-700 text-sm font-bold mb-2">Rental Date:</label>
                <input type="date" id="rental_date" name="rental_date" value="<?php echo $contract -> getRentalDate() ?>" required class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>

            <div class="mb-4">
                <label for="return_date" class="block text-gray-700 text-sm font-bold mb-2">Return Date:</label>
                <input type="date" id="return_date" name="return_date" value="<?php echo $contract -> getReturnDate() ?>" class="shadow appearance-none border rounded w-full py-2 px-3">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Contract</button>
                <a href="view_rental_contracts.php" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
