<?php
include "query_overrides.php";
// We need to use sessions, so you should always start sessions using the below code.
/**
 * Verifies if a table exists in the database
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name Name of the table
 * @return bool true if the table exists in the database, false otherwise
 */
function verify_table($conn, $table_name) {
    $check_table_name = strtolower($table_name);
    $query = "SHOW TABLES";
    $result = $conn -> query($query);
    # echo $result;
    for($i=0; $row = $result->fetch_array(); $i++){
        if ($row[0] === $check_table_name) {
            return true;
        }
    }
    return false;
} 

/**
 * Verifies if a column exists in the database
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name Name of the table
 * @param string $col_name Name of the column in the table
 * @return bool true if the column for the table exists in the database, false otherwise
 */
function verify_column($conn, $table_name, $col_name) {
    $query = "SELECT * FROM " . $table_name;
    $result = $conn -> query($query);
    for($i=0; $field = $result->fetch_field(); $i++){
        if ($field->name === $col_name) {
            return true;
        }
    }
    return false;
} 

// Update a field in a table
if(isset($_POST['update_field']))
{
    // Dump previous output so only the following output is sent back to the post request
    ob_clean();
    $table_name = $_POST['table_name'];
    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_value = $_POST['new_value'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    $col_num = $_POST['col_num'];
    // Make sure table name and query is valid and that the table is editable
    if (!array_key_exists($table_name . $table_query_name, $data_editors)) {
        echo json_encode(array("Invalid table name and query!", ""));
        exit();
    }
    $valid_table = verify_table($conn, $table_query_name);
    if ($valid_table === false) {
        echo json_encode(array("Invalid Table Name!", ""));
    } else {
        # echo $valid_table;
        $valid_field = verify_column($conn, $table_query_name, $field_name);
        $valid_id_field = verify_column($conn, $table_query_name, $id_field);
        if ($valid_id_field  === false) {
            echo json_encode(array("Invalid ID Field Name!", ""));
        } else {
            try {
                $override_results = override_update_sql($conn, $table_name, $table_query_name, $field_name, $new_value, $col_num, $id_field, $id_value, $_SESSION["id"]);
                if ($override_results  === "NO_OVERRIDE") {
                    // We need to make sure the field name is valid first
                    if ($valid_field  === false) {
                        echo json_encode(array("Invalid Field Name!", ""));
                    }
                    $query = $conn -> prepare("UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?");
                    $query -> bind_param("ss", $new_value, $id_value);
                    $stmt = $query -> execute();
                    $result = $query -> get_result();
                    echo json_encode(array("Success!", $result));
                }
            } catch (Exception $ex) {
                echo json_encode(array(get_class($ex), $ex->getMessage()));
            }
            # echo "Made it to end";
        }
        
    }
    exit();
}

// Update a field in a table
if(isset($_POST['insert_row']))
{
    // Dump previous output so only the following output is sent back to the post request
    ob_clean();
    $table_name = $_POST['table_name'];
    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_values = $_POST['new_values'];
    $new_values_array = json_decode($new_values, true);
    # $id_field = $_POST['id_field'];
    // Make sure table name and query is valid and that the table is editable
    if (!array_key_exists($table_name . $table_query_name, $data_editors)) {
        echo json_encode(array("Invalid table name and query!", ""));
        exit();
    }
    $valid_table = verify_table($conn, $table_query_name);
    if ($valid_table === false) {
        echo json_encode(array("Invalid Table Name!", ""));
    } else {
        try {
            $override_results = override_insert_sql($conn, $table_name, $table_query_name, $new_values_array, $_SESSION["id"]);
            if ($override_results  === "NO_OVERRIDE") {
                $num_params = sizeof($new_values_array);
                $query = $conn -> prepare("INSERT INTO " . $table_query_name . " VALUES  (NULL, ". str_repeat("?, ", $num_params - 1) ."?)");
                $query -> bind_param(str_repeat("s", $num_params), ...$new_values_array);
                $stmt = $query -> execute();
                $result = $query -> get_result();
                echo json_encode(array("Success!", $result, $override_results));
            }
        } catch (Exception $ex) {
            echo json_encode(array(get_class($ex), $ex->getMessage(), $new_values_array));
        }
        # echo "Made it to end";
    }
    exit();
}

// Delete a row in a table
if(isset($_POST['delete_row']))
{
    // Dump previous output so only the following output is sent back to the post request
    ob_clean();
    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    // Make sure table name and query is valid and that the table is editable
    if (!array_key_exists($table_name . $table_query_name, $data_editors)) {
        echo json_encode(array("Invalid table name and query!", ""));
        exit();
    }
    $valid_table = verify_table($conn, $table_query_name);
    if ($valid_table === false) {
        echo json_encode(array("Invalid Table Name!", ""));
    } else {
        # echo $valid_table;
        $valid_field = verify_column($conn, $table_query_name, $field_name);
        if ($valid_field  === false) {
            echo json_encode(array("Invalid Field Name!", ""));
        } else {
            $valid_id_field = verify_column($conn, $table_query_name, $id_field);
            if ($valid_id_field  === false) {
                echo json_encode(array("Invalid ID Field Name!", ""));
            } else {
                try {
                    $query = $conn -> prepare("DELETE FROM " . $table_query_name . " WHERE " . $id_field . " = ?");
                    $query -> bind_param("s", $id_value);
                    $stmt = $query -> execute();
                    $result = $query -> get_result();
                    echo json_encode(array("Success!", $result));
                } catch (Exception $ex) {
                    echo json_encode(array(get_class($ex), $ex->getMessage()));
                }
                # echo "Made it to end";
            }
        }
    }
    exit();
}
?>