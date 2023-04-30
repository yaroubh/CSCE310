<?php
include "../res/head.php"; 
# include $backup . "res/table_editor.php"; 
# $result = $conn -> query("SHOW TABLES");
# print($result);
?>
<div>
    <h1 class = "text-center">Bookings (Receptionist View)</h1>
        <h2 class = "text-center">Hotels:</h2>
            <div id = "hotels-div">
                <?php 
                    $gtv_hotels = generate_table_view("hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf");
                    echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "text-center">Rooms:</h2>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_editable("rooms-div", "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_ID ASC", "Inf", ["text", "text", "text", "text"]);
                echo $gte_rooms;
            ?>
            </div>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gte_bookings = generate_table_editable("bookings-div", "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf", ["text", "text", "datetime-local::start", "datetime-local::end"]);
                echo $gte_bookings;    
            ?>
            </div>
</div>