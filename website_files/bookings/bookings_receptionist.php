<?php
include "../res/head.php"; 
# include $backup . "res/table_editor.php"; 
# $result = $conn -> query("SHOW TABLES");
# print($result);
?>
<div>
    <h1 class = "text-center">Bookings (Receptionist View)</h1>
        <h2 class = "text-center">Hotels:</h2>
            <?php 
                $gtv_hotels = generateTableView($conn, "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf");
                echo $gtv_hotels;    
            ?>
        <h2 class = "text-center">Rooms:</h2>
            <?php 
                $gte_rooms = generateTableEditable($conn, "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_ID ASC", "Inf");
                echo $gte_rooms;
            ?>
        <h2 class = "text-center">Bookings:</h2>
            <?php
                $gte_bookings = generateTableEditable($conn, "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf");
                echo $gte_bookings;    
            ?>
</div>