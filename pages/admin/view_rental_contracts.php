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

    $conn = (new Database) -> connect();

    $user = new User($conn);
    $user -> fetchById($_SESSION['id']);

    $contract = new RentalContract($conn, $user);

    $contracts_result = $contract -> fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rental Contracts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar Section -->
    <?php include '../../inc/header.php'; ?>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">Rental Contracts List</h1>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Client Name</th> <!-- Show client name -->
                    <th class="py-2 px-4 border">License Plate</th>
                    <th class="py-2 px-4 border">Car Make</th>
                    <th class="py-2 px-4 border">Car Model</th>
                    <th class="py-2 px-4 border">Rental Date</th>
                    <th class="py-2 px-4 border">Return Date</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($contracts_result) > 0) {
                    foreach ($contracts_result as $row) {
                        echo "<tr class='text-center'>
                                <td class='py-2 px-4 border'>{$row['contract_id']}</td>
                                <td class='py-2 px-4 border'>{$row['username']}</td>
                                <td class='py-2 px-4 border'>{$row['license_plate']}</td>
                                <td class='py-2 px-4 border'>{$row['make']}</td>
                                <td class='py-2 px-4 border'>{$row['model']}</td>
                                <td class='py-2 px-4 border'>{$row['rental_date']}</td>
                                <td class='py-2 px-4 border'>{$row['return_date']}</td>
                                <td class='py-2 px-4 border'>
                                    <a href='edit_rental_contract.php?id={$row['contract_id']}' class='bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 inline-block'>Edit</a>
                                    <a href='delete_rental_contract.php?id={$row['contract_id']}' class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 inline-block'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center py-4'>No rental contracts found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
