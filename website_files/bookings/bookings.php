<?php
$suspend_head = true;
include "../res/head.php"; 

// Make the tables and filter objects
// Allows users to insert, view, edit, and delete their own bookings
$bookings_user_table = generate_data_editor($data_editors, $data_tables, "bookings-user-div", "b-rv-bookings-user", "Booking", "SELECT Booking.Booking_NO, Room.Room_Num, Hotel.Hotel_Name, Booking.Start_Date, Booking.End_Date FROM Booking INNER JOIN Room ON Room.Room_ID = Booking.Room_ID INNER JOIN Hotel ON Hotel.Hotel_ID = Room.Hotel_ID  ORDER BY Booking_NO ASC", "Inf", ["text", "text", "datetime-local::start", "datetime-local::end"], []);
// Allows users to see all bookings
$bookings_table = generate_data_table($data_tables, "bookings-div", "b-rv-bookings", "Booking", "SELECT Room.Room_Num, Hotel.Hotel_Name, Booking.Start_Date, Booking.End_Date FROM Booking INNER JOIN Room ON Room.Room_ID = Booking.Room_ID INNER JOIN Hotel ON Hotel.Hotel_ID = Room.Hotel_ID  ORDER BY Booking_NO ASC", "Inf", ["text", "text", "datetime-local::start", "datetime-local::end"], []);
// Allows users to see hotels
$hotels_table = generate_data_table($data_tables, "hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel_View", "Inf", ["text", "text", "text", "text"], []);
// Allows users to see rooms
$rooms_table = generate_data_table($data_tables, "rooms-div", "b-rv-rooms", "Room", "SELECT Hotel.Hotel_Name, Hotel.Hotel_City, Hotel.Hotel_State, Hotel.Hotel_Country, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID", "Inf", ["text", "text", "text", "text", "text", "text", "text"], []);

// Add the ability to filter through rooms that are open (i.e. it currently is not reserved in Booking)
// This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
// WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?)
// The date parameters will be binded to the query
$filter_dates_rooms_objs = generate_date_range_filter_objs($data_filters, "rooms-dates-filter", "b-rv-rooms", "NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date", "", "End_Date", ")", "Select Rooms Open From", "2023-04-30 10:09:00" ,"2030-05-30 10:09:00");
// Add the ability to filter by hotel name 
// This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
// WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
// AND Hotel.Hotel_Name = ?
$filter_hotel_rooms_obj = generate_search_filter_obj($data_filters, "rooms-hotel-filter", "b-rv-rooms", "Hotel.Hotel_Name", "=" , "", "s", "Hotel Name", "");
// Add the ability to filter by maximum price 
// This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
// WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
// AND Hotel.Hotel_Name = ?
// AND Room.Price <= ?
$filter_max_price_rooms_obj = generate_search_filter_obj($data_filters, "rooms-price-max-filter", "b-rv-rooms", "Room.Price", "<=" , "", "d", "Max Room Price", "");
// Add the ability to filter by minimum capacity
// This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
// WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
// AND Hotel.Hotel_Name = ?
// AND Room.Price <= ?
// AND Room.Capacity >= ?
$filter_min_capacity_rooms_obj = generate_search_filter_obj($data_filters, "rooms-capacity-min-filter", "b-rv-rooms", "Room.Capacity", ">=" , "", "i", "Min Room Capacity", "");

// Include the query handler and table generator files
include $backup . "res/query_handler.php";
include $backup . "res/table_generator.php";

// Print all the stuff in head like navbar
echo ob_get_clean();
?>

<div>
    <h1 class = "text-center">Bookings</h1>
        <h2 class = "text-center">Bookings:</h2>
            <div id = "bookings-user-div">
            <?php
                $gte_bookings = generate_table_editable($bookings_user_table);
                echo $gte_bookings;   
            ?>
            </div>
        <h2 class = "text-center">Current Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gtv_bookings = generate_table_view($bookings_table);
                echo $gtv_bookings;    
                // Add a dependency to the bookings_user_table. This causes this view to update when the user edits the table bookings_user_table
                $bookings_dep1 = generate_table_dependency($bookings_user_table, $bookings_table);
                echo $bookings_dep1;
            ?>
            </div>
        <h2 class = "text-center">Hotels:</h2>
            <div id = "hotels-div">
                <?php 
                $gtv_hotels = generate_table_view($hotels_table);
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
                $filter_dates_rooms = generate_date_range_filter($filter_dates_rooms_objs[0], $filter_dates_rooms_objs[1]);
                echo $filter_dates_rooms;
                // Add the ability to filter by hotel name 
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                $filter_hotel_rooms = generate_search_filter($filter_hotel_rooms_obj);
                echo $filter_hotel_rooms;
                // Add the ability to filter by maximum price 
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                // AND Room.Price <= ?
                $filter_max_price_rooms = generate_search_filter($filter_max_price_rooms_obj);
                echo $filter_max_price_rooms;
                // Add the ability to filter by minimum capacity
                // This essentially changes the Query to "SELECT Hotel.Hotel_Name, Room.Room_Num, Room.Price, Room.Capacity FROM Room Inner Join Hotel ON Room.Hotel_ID = Hotel.Hotel_ID
                // WHERE NOT EXISTS (SELECT * FROM Booking WHERE Booking.Room_ID = Room.Room_ID AND Start_Date > ? AND End_Date < ?) 
                // AND Hotel.Hotel_Name = ?
                // AND Room.Price <= ?
                // AND Room.Capacity >= ?
                $filter_min_capacity_rooms = generate_search_filter($filter_min_capacity_rooms_obj);
                echo $filter_min_capacity_rooms;
            ?>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_view($rooms_table);
                echo $gte_rooms;
            ?>
            </div>
</div>