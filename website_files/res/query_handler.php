<?php
include "connect.php";

# Verify a table exists in the database
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

# Verify a column exists in the database
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

function key_code_check($generated_key_code, $check_key_code) {
    if ($generated_key_code !== $check_key_code) {
        return false;
    } else {
        return true;
    }
}

# Update a field in a table
if(isset($_POST['update_field']))
{

    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_value = $_POST['new_value'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    $check_key_code = $_POST['key_code'];
    $key_code = hash("md5", $table_query_name .  $field_name . str_repeat($id_field, 2) . str_repeat($id_value, 3) . "->1");
    # Verify the key code
    $good_key_code = key_code_check($key_code, $check_key_code);
    if ($good_key_code === false) {
        echo json_encode(array("Invalid key code!", ""));
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
                echo json_encode(arrray("Invalid ID Field Name!", ""));
            } else {
                try {
                    $query = $conn -> prepare("UPDATE " . $table_query_name . " SET " . $field_name ." = ? WHERE " . $id_field . " = ?");
                    $query -> bind_param("ss", $new_value, $id_value);
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

if(isset($_POST['get_field']))
{
    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_value = $_POST['new_value'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    $check_key_code = $_POST['key_code'];
    $key_code = hash("md5", $table_query_name .  $field_name . str_repeat($id_field, 2) . str_repeat($id_value, 3) . "->1");
    # Verify the key code
    $good_key_code = key_code_check($key_code, $check_key_code);
    if ($good_key_code === false) {
        echo json_encode(array("Invalid key code!", ""));
        exit();
    }
    $valid_table = verify_table($conn, $table_query_name);
    if ($valid_table === false) {
        echo json_encode(arrray("Invalid Table Name!"));
    } else {
        # echo $valid_table;
        $valid_field = verify_column($conn, $table_query_name, $field_name);
        if ($valid_field  === false) {
            echo json_encode(arrray("Invalid Field Name!"));
        } else {
            $valid_id_field = verify_column($conn, $table_query_name, $id_field);
            if ($valid_id_field  === false) {
                echo json_encode(arrray("Invalid ID Field Name!"));
            } else {
                try {
                    $query = $conn -> prepare("SELECT " . $field_name . " FROM " . $table_query_name ." WHERE " . $id_field . " = ?");
                    $query -> bind_param("s", $id_value);
                    $stmt = $query -> execute();
                    $result = $query -> get_result();
                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                        $data[] = $row;
                    }
                    echo json_encode(array("Success!", $data));
                } catch (Exception $ex) {
                    echo json_encode(array(get_class($ex), $ex->getMessage()));
                }
                # echo "Made it to end";
            }
        }
    }
    exit();
}

# Update a field in a table
if(isset($_POST['insert_row']))
{

    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $new_values = $_POST['new_values'];
    $new_values_array = json_decode($new_values, true);
    # $id_field = $_POST['id_field'];
    $check_key_code = $_POST['key_code'];
    $key_code = hash("md5", $table_query_name . str_repeat($field_name, 3) . "||>" . str_repeat($field_name, 2) . "||>INSERT");
    # Verify the key code
    $good_key_code = key_code_check($key_code, $check_key_code);
    if ($good_key_code === false) {
        echo json_encode(array("Invalid key code!", ""));
        exit();
    }
    $valid_table = verify_table($conn, $table_query_name);
    if ($valid_table === false) {
        echo json_encode(array("Invalid Table Name!", ""));
    } else {
        try {
            $num_params = sizeof($new_values_array);
            $query = $conn -> prepare("INSERT INTO " . $table_query_name . " VALUES  (NULL, ". str_repeat("?, ", $num_params - 1) ."?)");
            $query -> bind_param(str_repeat("s", $num_params), ...$new_values_array);
            $stmt = $query -> execute();
            $result = $query -> get_result();
            echo json_encode(array("Success!", $result));
        } catch (Exception $ex) {
            echo json_encode(array(get_class($ex), $ex->getMessage()));
        }
        # echo "Made it to end";
    }
    exit();
}

# Delete a row in a table
if(isset($_POST['delete_row']))
{

    $table_query_name = $_POST['table_query_name'];
    $field_name = $_POST['field_name'];
    $id_field = $_POST['id_field'];
    $id_value = $_POST['id_value'];
    $check_key_code = $_POST['key_code'];
    $key_code = hash("md5", $table_query_name .  $field_name . str_repeat($id_field, 3) . str_repeat($id_value, 2) . "=>DELETE<=");
    # Verify the key code
    $good_key_code = key_code_check($key_code, $check_key_code);
    if ($good_key_code === false) {
        echo json_encode(array("Invalid key code!", ""));
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
                echo json_encode(arrray("Invalid ID Field Name!", ""));
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