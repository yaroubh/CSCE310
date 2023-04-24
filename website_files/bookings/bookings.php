<?php
include "../res/head.php"; 
?>
<div>
    <h1>Bookings</h1>
        <h2>Welcome <?php echo $_SESSION['name']?></h2>
        <div id = "hotels-div">
                <?php 
                    $gtv_hotels = generate_table_view("hotels-div", "b-rv-hotels", "Hotel", "SELECT Hotel_Name, Hotel_City, Hotel_State, Hotel_Country FROM Hotel ORDER BY Hotel_ID ASC", "Inf");
                    echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "text-center">Rooms:</h2>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_view("rooms-div", "b-rv-rooms", "Room", "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID ORDER BY Room_ID ASC", "Inf");
                echo $gte_rooms;
            ?>
            </div>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gte_bookings = generate_table_editable("bookings-div", "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf");
                echo $gte_bookings;    
            ?>
            </div>
</div>