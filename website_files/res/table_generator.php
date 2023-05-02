<?php 
include "connect.php";

/**
 * Generates data for an non-editable table view
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name id of table element
 * @param string $table_query_name Name of table used in the query
 * @param string $query Query to be executed
 * @return array Array containing information useful for front end to construct the table view
 */
function get_table_viewable_data($conn, $table_name, $table_query_name, $query) {
        // Execute Query
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt -> get_result();
        // Generate table information
        return generate_table_viewable_helper($table_name, $table_query_name, $result);
}

/**
 * Generates data for an non-editable table view with filters
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name id of table element
 * @param string $table_query_name Name of table used in the query
 * @param string $query Query to be executed
 * @param string[] $filters List of filters to be added to the query 
 * @return array Array containing information useful for front end to construct the table view
 */
function get_table_viewable_data_filterable($conn, $table_name, $table_query_name, $query, $filters) {
    // Put filters into query
    // NOTE: Filters have the following format:
    // 1st param - Start of filter string
    // 2nd param - Filter operator
    // 3rd param - End of filter string
    // 4th param - Filter type (string, int, double, etc.)
    // 5th param - Filter value to be binded
    // 6th param - Filter key code
    $filter_params = array();
    $filter_types = "";
    $query .=  " WHERE ";
    // Apply each filter to the query
    for ($i = 0; $i < sizeof($filters); $i++) {
        $curr_filter = $filters[$i];
        $query .= $curr_filter[0] . " " . $curr_filter[1] . " ?" . $curr_filter[2];
        $filter_types .= $curr_filter[3];
        array_push($filter_params, $curr_filter[4]);
        // Add an AND if this is not the last condition to filter through
        if ($i < sizeof($filters) - 1) {
            $query .= " AND ";
        }
    }
    // return $query;
    // Execute Query
    $stmt = $conn->prepare($query);
    $stmt -> bind_param($filter_types, ...$filter_params);
    $stmt -> execute();
    $result = $stmt -> get_result();
    // Generate the table
    return generate_table_viewable_helper($table_name, $table_query_name, $result);
}


/**
 * Generates data for an non-editable table view
 *
 * @param string $table_name id of table element
 * @param string $table_query_name Name of table used in the query
 * @param mysqli_result $result The result of the MySQL query
 * @return array An array containing information to build the table on the front end.
 */
function generate_table_viewable_helper($table_name, $table_query_name, $result) {
    // Generate the table header row
    $field_array = array();
    $id_field = "";
    $data_array = array();
    $field_name_array = array();
    for ($i = 0; $field = $result -> fetch_field(); $i++)
    { 
        if ($i == 0) {
            // store the id field
            $id_field = $field->name;
        }
        // Add field to front of array
        array_unshift($field_array, $field);
        array_push($field_name_array, $field->name);
    }
    // Add the field array to our data array
    array_push($data_array, $field_name_array);
    // Go through and add each row of data
    $row_data_array = array();
    for($i=0; $row = $result -> fetch_row(); $i++){
        $field_array_copy = $field_array;
        $curr_row_data = array();
        for($j=0; $field = array_pop($field_array_copy); $j++){
            $curr_field_array = array();
            array_push($curr_field_array, $table_name);
            array_push($curr_field_array, $table_query_name);
            array_push($curr_field_array, $field->name);
            array_push($curr_field_array, $id_field);
            array_push($curr_field_array, $row[0]);
            array_push($curr_field_array, $i);
            array_push($curr_field_array, $j);
            array_push($curr_field_array, $row[$j]);
            
            // Add the data from our current field to the current row array
            array_push($curr_row_data, $curr_field_array);
        }
        // Add the data from our current row to our total row array
        array_push($row_data_array, $curr_row_data);
    }
    // Add the total row array to our data array that will be returned to the post request
    array_push($data_array, $row_data_array);

    // Return the data array
    return $data_array;
}



/**
 * Generates data for an non-editable table view
 *
 * @param mysqli $conn MySQLi connection object
 * @param string $table_name id of table element
 * @param string $table_query_name Name of table used in the query
 * @param string $query Query to be executed
 * @return array Array containing information useful for front end to construct the table view
 */
function get_editable_table_data($conn, $table_name, $table_query_name, $query) {
    // Execute query
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt -> get_result();
    return generate_table_editable_helper($table_name, $table_query_name, $result);
}

/**
 * Generates data for an editable table view
 *
 * @param string $table_name id of table element
 * @param string $table_query_name Name of table used in the query
 * @param mysqli_result $result The result of the MySQL query
 * @return array An array containing information to build the table on the front end.
 */
function generate_table_editable_helper($table_name, $table_query_name, $result) {
    // Generate the table header row
    $field_array = array();
    $id_field = "";
    $data_array = array();
    $field_name_array = array();
    for ($i = 0; $field = $result -> fetch_field(); $i++)
    { 
        if ($i == 0) {
            // store the id field
            $id_field = $field->name;
        }
        // Add field to front of array
        array_unshift($field_array, $field);
        array_push($field_name_array, $field->name);
    }
    // Add the field array to our data array
    array_push($data_array, $field_name_array);
    // Go through and add each row of data
    $row_data_array = array();
    for($i=0; $row = $result->fetch_row(); $i++){
        $field_array_copy = $field_array;
        $curr_row_data = array();
        for($j=0; $field = array_pop($field_array_copy); $j++){
            $curr_field_array = array();
            if ($j != 0) {
                // We only want the non-primary key columns to be editable.
                array_push($curr_field_array, $table_name);
                array_push($curr_field_array, $table_query_name);
                array_push($curr_field_array, $field->name);
                array_push($curr_field_array, $id_field);
                array_push($curr_field_array, $row[0]);
                array_push($curr_field_array, $i);
                array_push($curr_field_array, $j);
                array_push($curr_field_array, $row[$j]);
            } else {
                array_push($curr_field_array, $row[$j]);
            }
            // Add the data from our current field to the current row array
            array_push($curr_row_data, $curr_field_array);
        }
        // Add the data from our current row to our total row array
        array_push($row_data_array, $curr_row_data);
    }
    // Add the total row array to our data array that will be returned to the post request
    array_push($data_array, $row_data_array);

    // Generate the input field data
    $input_field_array = array();
    array_push($input_field_array, $table_name);
    array_push($input_field_array, $table_query_name);
    array_push($input_field_array, $id_field);
    array_push($input_field_array, $id_field);
    array_push($input_field_array, sizeof($field_array));
    
    // Add the input field array to the return data array
    array_push($data_array, $input_field_array);

    // Return the data array
    return $data_array;
}

/**
 * Checks the validity of key codes of filters 
 *
 * @param string[] $filters Array of filters 
 * @return bool Whether or not the filters each have valid key codes
 */
function filter_key_code_check($filters) {
    // The filter array is contained of tuples
    // The first element is the condition text start
    // The second element is the condition operator
    // The third element is the condition text end
    // The fourth element is the condition value type
    // The fifth element is the condition value (not part of key code because it's variable)
    // The sixth element is the key code
    for($i=0; $i < sizeof($filters); $i++){
        // Extract values from current filter tuple
        $curr_filter = $filters[$i];
        $cond_text_start = $curr_filter[0];
        $cond_op = $curr_filter[1];
        $cond_text_end = $curr_filter[2];
        $cond_type = $curr_filter[3];
        $check_key_code = $curr_filter[5];
        // Verify validity of key code
        $key_code = hash("md5", "||KEY_CODE||" . $cond_text_start . str_repeat($cond_op, 3) . $cond_type . $cond_text_end .  "-KC");
    }
    return true;
}


// Generate an editable table
if(isset($_POST['generate_table_editable']))
{
    ob_get_clean();
    // Get POST fields
    $table_name = $_POST['table_name'];
    $table_query_name = $_POST['table_query_name'];
    // $check_key_code = $_POST['key_code'];
    // Make sure table name and query is valid
    if (!array_key_exists($table_name . $table_query_name, $data_tables)) {
        echo json_encode(array("Invalid table name and query!", ""));
        exit();
    }
    // Get the table data
    $table = $data_tables[$table_name . $table_query_name];
    $table_array = get_editable_table_data($conn, $table_name, $table_query_name, $table -> query);
    echo json_encode(array("Success!", $table_array));
    exit();
}

// Generate an non-editable table
if(isset($_POST['generate_table_viewable']))
{
    ob_get_clean();
    // Get POST fields
    $table_name = $_POST['table_name'];
    $table_query_name = $_POST['table_query_name'];
    if (!array_key_exists($table_name . $table_query_name, $data_tables)) {
        echo json_encode(array("Invalid table name and query!", ""));
        exit();
    }
    // Get the table data
    $table = $data_tables[$table_name . $table_query_name];
    // Check if we have filters
    if (isset($_POST["filters"])) {
        $filters_json = $_POST['filters'];
        // Extract filter arrays
        $filters = json_decode($filters_json, true);
        // Check validity of filters
        $good_key_code = filter_key_code_check($filters);
        if ($good_key_code === false) {
            echo json_encode(array("Invalid filter key code!", ""));
            exit();
        }
        $table_array = get_table_viewable_data_filterable($conn, $table_name, $table_query_name, $table -> query, $filters);
        echo json_encode(array("Success!", $table_array));
        exit();
    } else {
        // Make the table
        $table_array = get_table_viewable_data($conn, $table_name, $table_query_name, $table -> query);
        echo json_encode(array("Success!", $table_array));
        exit();
    }
}


?>