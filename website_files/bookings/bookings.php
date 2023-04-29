<?php
include "../res/head.php"; 
?>
<div>
    <h1>Bookings</h1>
        <h2>Welcome <?php echo $_SESSION['name']?></h2>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gtv_bookings = generate_table_view("bookings-div", "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf");
                echo $gtv_bookings;    
            ?>
            </div>
            <h2 class = "text-center">Hotels:</h2>
        <div id = "hotels-div">
                <?php 
                $gtv_hotels = generate_table_view("hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel_View", "Inf");
                echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "text-center">Rooms:</h2>
            <p class = "text-center">Note: Price is per day</p>
            <div id = "rooms-filter-div">
            <?php
                // Add the ability to filter through rooms that are open (i.e. it currently is not reserved in Booking)
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?)
                // The date parameters will be binded to the query
                $filter_dates_rooms = generate_date_range_filter("rooms-dates-filter", "b-rv-rooms", "NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date", "", "End_Date", ")", "Select Rooms Open From", "2023-04-30 10:09:00" ,"2030-05-30 10:09:00");
                echo $filter_dates_rooms;
                // Add the ability to filter by hotel name 
                $filter_hotel_rooms = generate_search_filter("rooms-hotel-filter", "b-rv-rooms", "Hotel.Hotel_Name", "=" , "", "s", "Hotel Name");
                echo $filter_hotel_rooms;
                // Add the ability to filter by maximum price 
                $filter_max_price_rooms = generate_search_filter("rooms-price-max-filter", "b-rv-rooms", "Room.Price", "<" , "", "d", "Max Room Price");
                echo $filter_max_price_rooms;
                // Add the ability to filter by minimum capacity
                $filter_min_capacity_rooms = generate_search_filter("rooms-capacity-min-filter", "b-rv-rooms", "Room.Capacity", ">" , "", "i", "Min Room Capacity");
                echo $filter_min_capacity_rooms;
            ?>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_view("rooms-div", "b-rv-rooms", "Room", "SELECT Hotel.Hotel_Name, Hotel.Hotel_City, Hotel.Hotel_State, Hotel.Hotel_Country, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID", "Inf");
                echo $gte_rooms;
            ?>
            </div>
</div>