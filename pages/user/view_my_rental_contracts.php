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

    $contract = new RentalContract($conn, $user);

    $contracts_result = $contract -> fetchMyContracts();

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
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-6">My Contracts</h1>

        <table class="min-w-full bg-white shadow-md rounded text-center">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Client Name</th>
                    <th class="py-2 px-4 border">Car Make</th>
                    <th class="py-2 px-4 border">Car Model</th>
                    <th class="py-2 px-4 border">Rental Date</th>
                    <th class="py-2 px-4 border">Return Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($contracts_result) > 0) {
                    foreach ($contracts_result as $row) {
                        echo "<tr>
                                <td class='py-2 px-4 border'>{$row['id']}</td>
                                <td class='py-2 px-4 border'>{$row['username']}</td>
                                <td class='py-2 px-4 border'>{$row['make']}</td>
                                <td class='py-2 px-4 border'>{$row['model']}</td>
                                <td class='py-2 px-4 border'>{$row['rental_date']}</td>
                                <td class='py-2 px-4 border'>{$row['return_date']}</td>
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
