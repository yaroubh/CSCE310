<?php
include "../res/head.php"; 
# include $backup . "res/table_editor.php"; 
# $result = $conn -> query("SHOW TABLES");
# print($result);
?>
<div>
    <h1 class = "text-center">Bookings (Receptionist View)</h1>
        <h2 class = "text-center">Hotels:</h2>
            <?php echo generateTableView($conn, "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf")?>
        <h2 class = "text-center">Rooms:</h2>
            <?php echo generateTableEditable($conn, "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_Num ASC", "Inf")?>
        <h2 class = "text-center">Bookings:</h2>
            <?php echo generateTableView($conn, "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf")?>
</div>