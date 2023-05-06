<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file includes functions that override the default insert and update code found in query_handler.php.
This is included in query_handler.php. This file is necessary for data_tables that do not have 
Select statements that are not in the format of "SELECT * FROM". Different logic is required
for updating and inserting for these data_table objects. For example, b-rv-users

----------------------------------------------------------------------------------------------->
<?php
/**
 * Overrides the insertion of elements into a table
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name ID of table element
 * @param string $table_query_name Name of table to be used in query
 * @param array $field_array List of field values to be inserted
 * @param int $user_id ID of the user
 * @return string Status of performing override
 */
function override_insert_sql($conn, $table_name, $table_query_name, $field_array, $user_id) {
    if  ($table_name === "b-rv-bookings-user") {
        // Override the user's bookings table in bookings.php
        $stmt = $conn->prepare('SELECT Room.Room_ID FROM Room Inner Join Hotel on Hotel.Hotel_ID = Room.Hotel_ID WHERE Room.Room_Num = ? AND Hotel.Hotel_Name = ?');
        // Bind parameters (s = string, i = int, b = blob, etc)
        $stmt->bind_param('ss', $field_array[0], $field_array[1]);
        $stmt->execute();
        $stmt->store_result();
        $num_results = $stmt -> num_rows();
        if ($num_results > 0) {
            $stmt -> bind_result($room_id);
            $stmt -> fetch();
            $stmt -> close();
            // Reorder the fields for the booking parameters now that we have the room id and user id
            // The first field is room_id
            // The second field is the user_id
            // The third field is the start date of the booking
            // The fourth field is the end date of the booking
            $new_field_array = array();
            array_push($new_field_array, $room_id);
            array_push($new_field_array, $user_id);
            for ($i = 2; $i < sizeof($field_array); $i++) {
                array_push($new_field_array, $field_array[$i]);
            }
            $field_array = $new_field_array;
            $num_params = sizeof($field_array);
            // Execute the overrided insert SQL statement for a booking
            $query = $conn -> prepare("INSERT INTO " . $table_query_name . " VALUES  (NULL, ". str_repeat("?, ", $num_params - 1) ."?)");
            $query -> bind_param("ii" . str_repeat("s", $num_params - 2), ...$field_array);
            $stmt = $query -> execute();
            $result = $query -> get_result();
            echo json_encode(array("Success!", $result));
            return "SUCCESS";
        } else {
            echo json_encode(array("mysqli_sql_exception", "No room matches that room number and hotel name!"));
            return "FAILURE";
        }
    }    
    else if($table_name === "b-rv-users"){
        // Override the customers table in the Accounts Admin view
        $num_params = sizeof($field_array);

        // Execute the SQL statement
        $query = $conn -> prepare("INSERT INTO Users (FName, LName, Phone_NO, Email, Username, Password, User_Type) VALUES (". str_repeat("?, ", $num_params - 1) ."?, 'Customer')");
        $query -> bind_param(str_repeat("s", $num_params), ...$field_array);
        $stmt = $query -> execute();
        $result = $query -> get_result();
        echo json_encode(array("Success!", $result));
        return "SUCCESS";

    } else if ($table_name === "b-rv-emps") {
        // Override the employees table in the Accounts Admin view
        $num_params = sizeof($field_array);
        // Insert the employees data into the users table
        $stmt = $conn->prepare('INSERT INTO users (fname, lname, phone_no, email, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, "Employee")');
        # The first parameter indicates the types of variables for each column
        # the first column, fname should be a string, so it's "s"
        # The last custom column, phone_no, should be an integer, so it's "i"
        # There are six custom columns, so there are 6 letters, one for each column
        $user_params = array_slice($field_array, 0, 6);
        $stmt->bind_param('ssisss', ...$user_params);
        $stmt->execute(); 
        $stmt->close();

        // We now need to get the user id
        $stmt = $conn->prepare('SELECT user_id FROM users WHERE username = ?');
        // In this case we want to get the user id and bind the result to it.
        $stmt->bind_param('s', $field_array[4]);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        // Insert into employees table
        $stmt = $conn->prepare('INSERT INTO employees (user_id, hotel_id, employee_jobtype) VALUES (?, ?, ?)'); 
        $stmt->bind_param('sis', $user_id, $field_array[6], $field_array[7]);
        $result = $stmt -> execute();
        echo json_encode(array("Success!", $result));
        return "SUCCESS";

        
    } else {
        // echo "No override for " . $table_name;
        return "NO_OVERRIDE";
    }
}

/**
 * Overrides the update elements of a table
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name ID of table element
 * @param string $table_query_name Name of table to be used in query
 * @param string $field_name Name of the column to be updated
 * @param string $field_value Value of the attribute to be updated
 * @param int $col_num The column number of the field
 * @param string $id_field The ID field used in the table
 * @param string $id_value The unique id for the row we are updating
 * @param int $user_id ID of the user
 * @return string Status of performing override
 */
function override_update_sql($conn, $table_name, $table_query_name, $field_name, $field_value, $col_num, $id_field, $id_value, $user_id) {
    if  ($table_name === "b-rv-bookings-user") {
        // Override the user's bookings table in bookings.php
        // Get the ID of the room, the room number, and the hotel name
        $stmt = $conn->prepare('SELECT Room.Room_ID, Room.Room_Num, Hotel.Hotel_Name FROM Booking Inner Join Room ON Booking.Room_ID = Room.Room_ID Inner Join Hotel ON Hotel.Hotel_ID = Room.Hotel_ID WHERE Booking.Booking_NO = ?');
        // Bind parameters (s = string, i = int, b = blob, etc)
        $stmt->bind_param('i', $id_value);
        $stmt->execute();
        $stmt->store_result();
        $num_results = $stmt -> num_rows();
        if ($num_results > 0) {
            $stmt -> bind_result($room_id, $room_num, $hotel_name);
            $stmt -> fetch();
            $stmt -> close();
            // We now need to check if the field_name is room_num or hotel_name
            if ($col_num === "1" || $col_num === "2") {
                // We need to update the room_id
                $stmt = $conn->prepare("SELECT Room.Room_ID FROM Room Inner Join Hotel on Hotel.Hotel_ID = Room.Hotel_ID WHERE Room.Room_Num = ? AND Hotel.Hotel_Name = ?");
                // Bind parameters (s = string, i = int, b = blob, etc)
                if ($col_num === "1") {
                    // We are changing the room number -> keep hotel name, but change room number (which is field_value)
                    $stmt->bind_param('is', $field_value, $hotel_name);
                } else {
                    // We are changing the hotel name -> keep room number, but change hotel name (which is field_value)
                    $stmt->bind_param('is', $room_num, $field_value);
                }
                $stmt -> execute();
                $stmt->store_result();
                $num_results = $stmt -> num_rows();
                if ($num_results > 0) {
                    // We now have the new room id to update in bookings
                    $stmt -> bind_result($new_room_id);
                    $stmt -> fetch();
                    $stmt -> close();
                    $query = $conn -> prepare("UPDATE Booking SET Booking.Room_ID = ? WHERE Booking.Booking_NO = ?");
                    $query -> bind_param("ii", $new_room_id, $id_value);
                    $stmt = $query -> execute();
                    $result = $query -> get_result();
                    echo json_encode(array("Success!", $result));
                    return "SUCCESS";
                } else {
                    echo json_encode(array("mysqli_sql_exception", "No room matches that room number and hotel name!", $field_value, $hotel_name));
                    return "FAILURE";
                }

            } else {
                // Simply need to update the dates for the bookings
                $query_sql = "UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?";
                $query = $conn -> prepare("UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?");
                $query -> bind_param("ss", $field_value, $id_value);
                $stmt = $query -> execute();
                $result = $query -> get_result();
                echo json_encode(array("Success!", $result, $query_sql, $field_value, $id_value));
                return "SUCCESS";
            }
        } else {
            echo json_encode(array("mysqli_sql_exception", "No room matches that id!"));
            return "FAILURE";
        }
    } else if ($table_name == "b-rv-emps") {
        // Update values in the employees table of the Accounts Admin view
        // Necessary for the last two columns -> which don't belong in Users -> requires different SQL
        if ($col_num === "7") {
            // Update the Hotel_ID in the employees table 
            $query = $conn -> prepare("UPDATE Employees SET Hotel_ID = ? WHERE " . $id_field . " = ?");
            $query -> bind_param("ii", $field_value, $id_value);
        } else if ($col_num === "8") {
            // Update the Employee_JobType in the employees table 
            $query = $conn -> prepare("UPDATE Employees SET Employee_JobType = ? WHERE " . $id_field . " = ?");
            $query -> bind_param("si", $field_value, $id_value);
        } else {
            // Other columns are updated by default in users table -> no need for an override
            return "NO_OVERRIDE";
        }
        $stmt = $query -> execute();
        $result = $query -> get_result();
        echo json_encode(array("Success!", $result));
        return "SUCCESS";
    } else {
        // echo "No override for " . $table_name;
        return "NO_OVERRIDE";
    }
}

?>