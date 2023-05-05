<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file includes tables useful for a administrators overseeing booking functionality. 
The first table displays all hotels and is editable.
The second table displays all rooms and is editable.
The third table displays all users.
The fourth table displays all bookings and is editable.

This file includes res/head.php, res/query_handler.php, res/table_generator.php, and res/toc.js.

res/head.php includes several files and some important file path variables that are used here.
It includes res/data_table.php, res/table_editor.js, and res/table_editor.php. These files are important
for generating the HTML and JS necessary to display the tables.

res/query_handler.php includes code to insert, update, and delete the editable tables. 

res/table_generator.php includes code to get the information to display the HTML and JS tables. 
Essentially, when res/table_editor.js performs a post request to generate an editable/non-editable table,
res/table_generator.php queries the database based off the select query stored in the data_table object, and
sends the information back to res/table_editor.js.

res/toc.js includes code to generate a table of contents for all elements with the class "toc-header".
It is useful since there is a lot of tables, and users may want to jump to a specific section.

----------------------------------------------------------------------------------------------->

<?php
$suspend_head = true;
include "../res/head.php"; 

// Make the tables and filter objects
// Allows administrators to edit hotels
$hotels_table = generate_data_editor($data_editors, $data_tables, "hotels-div", "b-rv-hotels", "Hotel", "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "Inf", ["text", "text", "text", "text"], []);
// Allows administrators to edit rooms
$rooms_table = generate_data_editor($data_editors, $data_tables, "rooms-div", "b-rv-rooms", "Room", "SELECT * FROM Room ORDER BY Room_ID ASC", "Inf", ["text", "text", "text", "text"], []);
// Allows administrators to view users (they can edit them in login/admin_accounts.php)
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
                    // Output the HTML and JS for the editable hotels table.
                    $gtv_hotels = generate_table_editable($hotels_table);
                    echo $gtv_hotels;    
                ?>
            </div>
        <h2 class = "toc-header text-center" id = "rooms-toc-header">Rooms:</h2>
            <div id = "rooms-div">
            <?php 
                // Output the HTML and JS for the editable rooms table.
                $gte_rooms = generate_table_editable($rooms_table);
                echo $gte_rooms;
            ?>
            </div>
        <h2 class = "toc-header text-center" id = "users-toc-header">Users:</h2>
            <div id = "users-div">
            <?php 
                // Output the HTML and JS for the non-editable users table.
                $gtv_users = generate_table_view($users_table);
                echo $gtv_users;
            ?>
            </div>
        <h2 class = "toc-header text-center" id = "bookings-toc-header">Bookings:</h2>
            <div id = "bookings-div">
            <?php
                // Output the HTML and JS for the editable bookings table.
                $gte_bookings = generate_table_editable($bookings_table);
                echo $gte_bookings;    
            ?>
            </div>
</div>

<script type="text/javascript" src="<?php echo $backup . "res/toc.js";?>"></script>