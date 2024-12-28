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

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $conn = (new Database) -> connect();

        $user = new User($conn);
        $user -> fetchById($_SESSION['id']);

        $contract = new RentalContract($conn, $user);
        $contract -> setId($id);

        if ($contract -> delete($id)) {
            header("Location: view_rental_contracts.php");
        } else {
            echo "Error: " . $contract -> error;
        }
    }

?>