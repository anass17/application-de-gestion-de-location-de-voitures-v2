<?php

    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: ../../auth/login.php");
        exit();
    }

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';
    require '../class/CarClass.php';

    if (isset($_GET['id'])) {
        $carId = $_GET['id'];

        $conn = (new Database) -> connect();

        $user = new User($conn);
        $user -> fetchById($_SESSION['id']);

        $car = new Car($conn, $user);
        $car -> setId($carId);

        $result = $car -> delete();

        header('Location: ../user/view_cars.php');
    }
?>
