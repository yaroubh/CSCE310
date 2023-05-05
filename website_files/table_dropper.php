<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file drops all tables.

----------------------------------------------------------------------------------------------->
<?php
include_once 'res/connect.php';

$sql = "SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS hotel;
DROP TABLE IF EXISTS booking;
DROP TABLE IF EXISTS room;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS hotel_service;
DROP TABLE IF EXISTS service_type;
DROP TABLE IF EXISTS service_assignment;
SET FOREIGN_KEY_CHECKS = 1;";

echo "<p>";
try {
    $stmt = $conn->multi_query($sql);
    if ($stmt === TRUE) {
        echo "Dropped tables and views";
    } else {
        echo "Error dropping tables and views: " . $conn->error;
    }
} catch (Exception $ex) {
        echo $ex;
}
echo "</p>";
?>