<?php
// This file overrides insertion, deletion, and updating of certain table values

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
            // Reorder the fields now that we have the room id and user id
            $new_field_array = array();
            array_push($new_field_array, $room_id);
            array_push($new_field_array, $user_id);
            for ($i = 2; $i < sizeof($field_array); $i++) {
                array_push($new_field_array, $field_array[$i]);
            }
            $field_array = $new_field_array;
            $num_params = sizeof($field_array);
            // Execute the SQL statement
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
    } else {
        echo "No override for " . $table_name;
        return "NO_OVERRIDE";
    }
}

/**
 * Overrides the update elements of a table
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name ID of table element
 * @param string $table_query_name Name of table to be used in query
 * @param array $field_array List of field values to be inserted
 * @param 
 * @param int $user_id ID of the user
 * @return string Status of performing override
 */
function override_update_sql($conn, $table_name, $table_query_name, $field_name, $field_value, $col_num, $id_field, $id_value, $user_id) {
    if  ($table_name === "b-rv-bookings-user") {
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
                // Simply need to update the dates
                $query = $conn -> prepare("UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?");
                $query -> bind_param("ss", $new_value, $id_value);
                $stmt = $query -> execute();
                $result = $query -> get_result();
                echo json_encode(array("Success!", $result));
                return "SUCCESS";
            }
        } else {
            echo json_encode(array("mysqli_sql_exception", "No room matches that id!"));
            return "FAILURE";
        }
    } else {
        echo "No override for " . $table_name;
        return "NO_OVERRIDE";
    }
}

?>