<?php
include "connect.php";

# Verify a table exists in the database
function verify_table($conn, $table_name) {
    $query = "SHOW TABLES";
    $result = $conn -> query($query);
    return $result;
    for($i=0; $row = $result->fetch_array(); $i++){
        if ($row[0] === $table_name) {
            return true;
        }
    }
    return false;
} 

# Verify a row exists in the database
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

# Update a field in a table
if(isset($_POST['update_field']))
{
    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_value = $_POST['new_value'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    $valid_table = verify_table($conn, $table_query_name);
    if (!$valid_table) {
        echo "Invalid Table Name!";
    } else {
        $valid_field = verify_table($conn, $table_query_name, $field_name);
        if (!$valid_field) {
            echo "Invalid Field Name!";
        } else {
            $valid_id_field = verify_table($conn, $table_query_name, $id_field);
            if (!$valid_id_field) {
                echo "Invalid ID Field Name!";
            } else {
                $query = $conn -> prepare("UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?");
                $query -> bind_param("ss", $new_value, $id_value);
                $result = $query -> execute();
                echo $result;
            }
        }
    }
}
?>