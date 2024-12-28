<?php

    include '../../inc/session_activity.php';

    require_once '../../vendor/autoload.php';
    require '../../connection/db.php';
    require '../../auth/UserClass.php';
    require '../class/carClass.php';
    require '../class/RentalContractClass.php';

    if (isset($_GET['id'])) {
        $clientId = $_GET['id'];

        $conn = (new Database) -> connect();

        $user = new User($conn);
        $user -> fetchById($clientId);

        

        $sql = "DELETE FROM Clients WHERE id = $clientId";

        if ($user -> delete()) {
            header("Location: view_users.php");
            exit;
        } else {
            echo "Error! " . $user -> error;
        }
    } else {
        echo "Client ID is missing.";
    }

?>
