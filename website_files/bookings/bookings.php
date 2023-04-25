<?php
include "../res/head.php"; 
?>
<div>
    <h1>Bookings</h1>
        <h2>Welcome <?php echo $_SESSION['name']?></h2>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gte_bookings = generate_table_editable("bookings-div", "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf");
                echo $gte_bookings;    
            ?>
            </div>
            <h2 class = "text-center">Hotels:</h2>
        <div id = "hotels-div">
                <?php 
                $gtv_hotels = generate_table_view("hotels-div", "b-rv-hotels", "Hotel", "SELECT Hotel_Name, Hotel_City, Hotel_State, Hotel_Country FROM Hotel ORDER BY Hotel_ID ASC", "Inf");
                echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "text-center">Rooms:</h2>
            <div id = "rooms-filter-div">
            <?php
                // Add the ability to filter through rooms that are open (i.e. it currently is not reserved in Booking)
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND < ?)
                $filter_dates_rooms = generate_date_range_filter("rooms-dates-filter", "b-rv-rooms", " WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date", "", "End_Date", ")", "Select Rooms Open From", "2023-04-30 10:09:00" ,"2030-05-30 10:09:00");
                echo $filter_dates_rooms;
            ?>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_view("rooms-div", "b-rv-rooms", "Room", "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID", "Inf");
                echo $gte_rooms;
            ?>
            </div>
</div>