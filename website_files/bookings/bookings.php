<?php
include "../res/head.php"; 
?>
<div>
    <h1 class = "text-center">Bookings <?php echo __FILE__ ?></h1>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-user-div">
            <?php
                $gte_bookings = generate_table_editable("bookings-user-div", "b-rv-bookings-user", "Booking", "SELECT Booking.Booking_NO, Room.Room_Num, Hotel.Hotel_Name, Booking.Start_Date, Booking.End_Date FROM Booking INNER JOIN Room ON Room.Room_ID = Booking.Room_ID INNER JOIN Hotel ON Hotel.Hotel_ID = Room.Hotel_ID  ORDER BY Booking_NO ASC", "Inf", ["text", "text", "datetime-local::start", "datetime-local::end"], []);
                echo $gte_bookings;   
            ?>
            </div>
        <h2 class = "text-center">Current Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gtv_bookings = generate_table_view("bookings-div", "b-rv-bookings", "Booking", "SELECT Room.Room_Num, Hotel.Hotel_Name, Booking.Start_Date, Booking.End_Date FROM Booking INNER JOIN Room ON Room.Room_ID = Booking.Room_ID INNER JOIN Hotel ON Hotel.Hotel_ID = Room.Hotel_ID  ORDER BY Booking_NO ASC", "Inf");
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
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                $filter_hotel_rooms = generate_search_filter("rooms-hotel-filter", "b-rv-rooms", "Hotel.Hotel_Name", "=" , "", "s", "Hotel Name");
                echo $filter_hotel_rooms;
                // Add the ability to filter by maximum price 
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                // AND Room.Price <= ?
                $filter_max_price_rooms = generate_search_filter("rooms-price-max-filter", "b-rv-rooms", "Room.Price", "<=" , "", "d", "Max Room Price");
                echo $filter_max_price_rooms;
                // Add the ability to filter by minimum capacity
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                // AND Room.Price <= ?
                // AND Room.Capacity >= ?
                $filter_min_capacity_rooms = generate_search_filter("rooms-capacity-min-filter", "b-rv-rooms", "Room.Capacity", ">=" , "", "i", "Min Room Capacity");
                echo $filter_min_capacity_rooms;
            ?>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_view("rooms-div", "b-rv-rooms", "Room", "SELECT Hotel.Hotel_Name, Hotel.Hotel_City, Hotel.Hotel_State, Hotel.Hotel_Country, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID", "Inf");
                echo $gte_rooms;
            ?>
            </div>
            <div class="form-group">
        
                <label for="date_time">Date and Time:</label>
                <input type="datetime-local" class="form-control" id="date_time" name="date_time">
        
                <label for="description">Review:</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
            </div>
        
            <button type="submit" class="btn btn-primary">Submit</button>
</div>