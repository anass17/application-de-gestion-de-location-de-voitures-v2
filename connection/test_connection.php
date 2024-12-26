<?php

include 'db.php';


$db = new Database();


$conn = $db->connect();


if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}
?>
