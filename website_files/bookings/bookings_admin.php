<?php
$suspend_head = true;
include "../res/head.php"; 

// Make the tables and filter objects
// Allows administrators to view hotels
$hotels_table = generate_data_editor($data_editors, $data_tables, "hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf", ["text", "text", "text", "text"], []);
// Allows administrators to edit rooms
$rooms_table = generate_data_editor($data_editors, $data_tables, "rooms-div", "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_ID ASC", "Inf", ["text", "text", "text", "text"], []);
// Allows administrators to view users
$users_table = generate_data_table($data_tables, "users-div", "b-rv-users", "Users", "SELECT User_ID, FName, LName, Phone_NO, Email, Username FROM Users ORDER BY User_ID ASC", "Inf", ["text, text, text, text, text"], []);
// Allows administrators to edit bookings
$bookings_table = generate_data_editor($data_editors, $data_tables, "bookings-div", "b-rv-bookings", "Booking", "SELECT * FROM Booking ORDER BY Booking_NO ASC", "Inf", ["text", "text", "datetime-local::start", "datetime-local::end"], []);

// Include the query handler and table generator files
include $backup . "res/query_handler.php";
include $backup . "res/table_generator.php";

// Print all the stuff in head like navbar
echo ob_get_clean();
?>
<div class = "content">
    <h1 class = "text-center">Bookings (Receptionist View)</h1>
        <h2 class = "toc-header text-center" id = "hotels-toc-header">Hotels:</h2>
            <div id = "hotels-div">
                <?php 
                    $gtv_hotels = generate_table_editable($hotels_table);
                    echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "toc-header text-center" id = "rooms-toc-header">Rooms:</h2>
            <div id = "rooms-div">
            <?php 
                $gte_rooms = generate_table_editable($rooms_table);
                echo $gte_rooms;
            ?>
            </div>
        <h2 class = "toc-header text-center" id = "users-toc-header">Users:</h2>
            <div id = "users-div">
            <?php 
                $gtv_users = generate_table_view($users_table);
                echo $gtv_users;
            ?>
            </div>
        <h2 class = "toc-header text-center" id = "bookings-toc-header">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                $gte_bookings = generate_table_editable($bookings_table);
                echo $gte_bookings;    
            ?>
            </div>
</div>

<script type="text/javascript" src="<?php echo $backup . "res/toc.js";?>"></script>