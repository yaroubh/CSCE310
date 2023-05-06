<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file includes functions that generate HTML and JS for both editable and non-editable data_tables.
It can also create two types of filters -> a simple search filter and a date range filter.
It calls functions that are in table_editor.js. Both of these files are included in head.php.
bookings.php shows examples of how to call these functions.

----------------------------------------------------------------------------------------------->
<?php
# include "res/head.php"; 

/**
 * Initializes the data table with its properties
 *
 * @param data_table[] $data_tables Array of data tables to add the table to for future use
 * @param string $parent_div ID of parent div
 * @param string $table_name ID of table element
 * @param string $table_query_name Name of table to be used in query
 * @param string $query Specific select query used to get data from MySQL database
 * @param string $max_width Max width of the table (or infinity if no width constraintE)
 * @param string[] $table_field_types The types of data in each column (ignoring the ID column)
 * @param string[] $table_opts Other table options
 * @return data_table The data table object that was created
 */
function generate_data_table(&$data_tables, $parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts) {
    // Make the table
    $table_temp = new data_table($parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts);
    // Insert it into the tables array (use both the table name and the table query name as a key)
    $data_tables[$table_name . $table_query_name] = $table_temp;
    return $table_temp;
}

/**
 * Initializes an editable data table with its properties
 *
 * @param data_table[] $data_editors Array of editable data tables to add the table to for future use
 * @param data_table[] $data_tables Array of data tables to add the table to for future use
 * @param string $parent_div ID of parent div
 * @param string $table_name ID of table element
 * @param string $table_query_name Name of table to be used in query
 * @param string $query Specific select query used to get data from MySQL database
 * @param string $max_width Max width of the table (or infinity if no width constraintE)
 * @param string[] $table_field_types The types of data in each column (ignoring the ID column)
 * @param string[] $table_opts Other table options
 * @return data_table The data table object that was created
 */
function generate_data_editor(&$data_editors, &$data_tables, $parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts) {
    // Make the table
    $table_temp = generate_data_table($data_tables, $parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts);
    // Insert it into the editors array (use both the table name and the table query name as a key)
    $data_editors[$table_name . $table_query_name] = $table_temp;
    return $table_temp;
}

/**
 * Initializes a filter object with its properties
 *
 * @param data_filter[] Array of filters to add the filter to for future use
 * @param string $div_name ID of filter
 * @param string $table_name ID of table
 * @param string $cond_name_start Starting string of the condition to filter by
 * @param string $cond_op The operation used in the filter ocondition
 * @param string $cond_name_end Ending string of the condition to filter by
 * @param string $cond_type The type of value we are checking in the filter condition
 * @param string $cond_label The text label given to the filter
 * @param string $default_value The default value in the filter element
 * @return data_filter The data filter object that was created
 */
function generate_data_filter(&$data_filters, $div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label, $default_value) {
    // Make the filter
    $filter_temp = new data_filter($div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label, $default_value);
    // Insert it into the filters array (use the div name and table name as a key)
    $data_filters[$div_name . $table_name] = $filter_temp;
    return $filter_temp;
}

/**
 * Generates a date range filter objects for a table
 *
 * @param data_filter[] $data_filter Div 
 * @param string $div_name Div name for this form
 * @param string $table_name Div name of the table we are filtering
 * @param string $sd_cond_name_start The start string of the start date condition (what comes before the operator)
 * @param string $sd_cond_name_end The end string of the start date condition (what comes before the operator)
 * @param string $ed_cond_name_start The start string of the end date condition (what comes before the operator)
 * @param string $ed_cond_name_end The end string of the end date condition (what comes after the value)
 * @param string $cond_label The label given to the date range form
 * @param string $default_start The default value for the starting date
 * @param string $default_end The default value for the ending date
 * @return data_filter[] An array containing the created date start filter and the date end filter
 */
function generate_date_range_filter_objs(&$data_filters, $div_name, $table_name, $sd_cond_name_start, $sd_cond_name_end, $ed_cond_name_start, $ed_cond_name_end, $cond_label, $default_start, $default_end) {
    // Make the filter objects - they will be stored in arrays for later due to the way generate_data_filter() works
    $date_start_filter = generate_data_filter($data_filters, $div_name . "-start", $table_name, $sd_cond_name_start, "<=", $sd_cond_name_end, "s", $cond_label, $default_start);
    $date_end_filter = generate_data_filter($data_filters, $div_name . "-end", $table_name, $ed_cond_name_start, ">=", $ed_cond_name_end, "s", $cond_label, $default_end);
    return array($date_start_filter, $date_end_filter);
}

/**
 * Generates a search range filter object for a table
 *
 * @param data_filter[] $data_filter Div 
 * @param string $div_name Div name for this form
 * @param string $table_name Div name of the table we are filtering
 * @param string $cond_name_start The start string of the condition (what comes before the operator)
 * @param string $cond_op The operator used for comparison in the filter
 * @param string $cond_name_end The end string of the condition (what comes after the operator)
 * @param string $cond_type The type of value that is being compared in the filter (s - string, i - int, d - double)
 * @param string $cond_label The label given to the search form
 * @param string $default_value The default value of the search filter
 * @return data_filter The data filter object that was created
 */
function generate_search_filter_obj(&$data_filters, $div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label, $default_value) {
    $search_filter = generate_data_filter($data_filters, $div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label, $default_value);
    return $search_filter;
}

?>


<?php
/**
 * Generates an editable table view
 *
 * @param data_table $table_object The table object we want to create
 * @return string The HTML / JS content of the table
 */
function generate_table_editable($table_object) {

    // Buffer the output so we can store it
    ob_start();
    ?>
    <script>
        // Store relevant data
        table_parents["<?php echo $table_object -> table_name?>"] = document.getElementById("<?php echo $table_object -> parent_div?>");
        table_qnames["<?php echo $table_object -> table_name?>"] = "<?php echo $table_object -> table_query_name?>";
        table_types["<?php echo $table_object -> table_name?>"] = "editor";
        table_mwidths["<?php echo $table_object ->table_name?>"] = "<?php echo $table_object -> max_width?>";
        table_field_types["<?php echo $table_object -> table_name?>"] = JSON.parse('<?php echo json_encode($table_object -> table_field_types)?>');
        table_opts["<?php echo $table_object -> table_name?>"] = JSON.parse('<?php echo json_encode($table_object -> table_opts)?>');
        table_input_child_htmls["<?php echo $table_object -> table_name?>"] = {};
        table_dependants["<?php echo $table_object -> table_name?>"] = [];
        // Generate the table
        generate_table_editable("<?php echo $table_object -> table_name?>", "<?php echo $table_object ->table_query_name?>", "<?php echo $table_object -> query?>", "<?php echo $table_object -> max_width?>");
    </script>
    <?php
    return ob_get_clean();
}?>

<?php
/**
 * Generates an editable table view
 *
 * @param data_table $table_object The table object we want to create
 * @return string The HTML / JS content of the table
 */
function generate_table_view($table_object) {

    // Buffer the output so we can store it
    ob_start();
    ?>
    <script>
        // Store relevant data
        table_parents["<?php echo $table_object -> table_name?>"] = document.getElementById("<?php echo $table_object -> parent_div?>");
        table_qnames["<?php echo $table_object -> table_name?>"] = "<?php echo $table_object -> table_query_name?>";
        table_types["<?php echo $table_object -> table_name?>"] = "viewer";
        table_mwidths["<?php echo $table_object -> table_name?>"] = "<?php echo $table_object -> max_width?>";
        table_field_types["<?php echo $table_object -> table_name?>"] = JSON.parse('<?php echo json_encode($table_object -> table_field_types)?>');
        table_opts["<?php echo $table_object -> table_name?>"] = JSON.parse('<?php echo json_encode($table_object -> table_opts)?>');
        table_dependants["<?php echo $table_object -> table_name?>"] = [];
        // Generate the table
        generate_table_view("<?php echo $table_object -> table_name?>", "<?php echo $table_object -> table_query_name?>", "<?php echo $table_object -> query?>", "<?php echo $table_object ->max_width?>");
    </script>
    <?php
    return ob_get_clean();
}?>

<?php
/**
 * Adds a dependency on a table, causing it to update when another table updates
 *
 * @param data_table $table Table object that is indepedent
 * @param data_table $dependent_table Table object that is dependent
 * @return string JavaScript for updating the table dependencies
 */
function generate_table_dependency($table, $dependent_table) {
    ob_start();
    ?>

    <script>
    table_dependants["<?php echo $table -> table_name?>"].push("<?php echo $dependent_table -> table_name?>");
    </script>
<?php 
    return ob_get_clean();
} ?>

<?php
/**
 * Generates the HTML and JS for the date range filter of a table
 *
 * @param data_filter[] $data_filter Div 
 * @param string $div_name Div name for this form
 * @param string $table_name Div name of the table we are filtering
 * @param string $sd_cond_name_start The start string of the start date condition (what comes before the operator)
 * @param string $sd_cond_name_end The end string of the start date condition (what comes before the operator)
 * @param string $ed_cond_name_start The start string of the end date condition (what comes before the operator)
 * @param string $ed_cond_name_end The end string of the end date condition (what comes after the value)
 * @param string $cond_label The label given to the date range form
 * @param string $default_start The default value for the starting date
 * @param string $default_end The default value for the ending date
 * @return string The HTML and JS Code for the date range filter
 */
function generate_date_range_filter($filter_start, $filter_end) {
    // Buffer the output so we can store it
    ob_start();
    $table_name = $filter_start -> table_name;
    ?>
    <script>
        // Initialize arrays for table filter maps
        if (table_filters["<?php echo $table_name?>"] == null) {
            table_filters["<?php echo $table_name?>"] = {};
        }
        if (table_filter_elements["<?php echo $table_name?>"] == null)  {
            table_filter_elements["<?php echo $table_name?>"] = {};
        }
        // Store relevant data
        table_filters["<?php echo $table_name?>"]['<?php echo $filter_end -> div_name?>'] = 
            ['<?php echo $filter_start -> default_value?>', true, '<?php echo $filter_start -> default_value?>'];
        table_filters["<?php echo $table_name?>"]['<?php echo $filter_start -> div_name?>'] = 
            ['<?php echo $filter_end -> default_value?>', true, '<?php echo $filter_end -> default_value?>'];
    </script>
    <div id = "<?php echo $filter_start -> div_name . "-" . $filter_end -> div_name?>-group" class = "date-range-group"> 
        <div class="form-check">
            <input class="form-check-input" 
                type="checkbox" value="" 
                id="flexCheckDefault-<?php echo $filter_start -> div_name . "-" . $filter_end -> div_name?>" 
                onClick = "toggle_filters('<?php echo $table_name?>', ['<?php echo $filter_start -> div_name?>', '<?php echo $filter_end -> div_name?>'])"
                checked>
            <label>Enable '<?php echo $filter_start -> cond_label ?>' Date Range
            </label>
        </div>
        <div id = "<?php echo $filter_start -> div_name . "-" . $filter_end -> div_name?>-form">
            <label for="date_time" class = "date-range-label"><?php echo $filter_start -> cond_label?></label>
            <input type = "datetime-local" 
                class = "form-control date-range-filter" 
                id = "<?php echo $filter_start -> div_name?>" 
                name = "date_time" 
                value = "<?php echo $filter_start -> default_value?>"
                onChange = "update_date('<?php echo $filter_start -> div_name?>', null,'<?php echo $filter_end -> div_name?>', '<?php echo $table_name?>', table_filters['<?php echo $table_name?>']['<?php echo $filter_start -> div_name?>'])">
            <p class = "date-range-text"> to </p>
            <input type = "datetime-local"
                class = "form-control date-range-filter" 
                id = "<?php echo $filter_end -> div_name?>" name="date_time"
                name = "date_time" 
                value = "<?php echo $filter_end -> default_value?>"
                onChange = "update_date('<?php echo $filter_end -> div_name?>', '<?php echo $filter_start -> div_name?>', null, '<?php echo $table_name?>', table_filters['<?php echo $table_name?>']['<?php echo $filter_end -> div_name?>'])">
        </div>
    </div>
    <?php
    return ob_get_clean();
}?>

<?php
/**
 * Generates the HTML and JS for the search filter of a table
 *
 * @param data_filter $filter The search filter object
 * @return string HTML for generating the search filter
 */
function generate_search_filter($filter) {
    // Buffer the output so we can store it
    ob_start();
    $table_name = $filter -> table_name;
    $div_name = $filter -> div_name;
    $cond_label = $filter -> cond_label;
    ?>
    <script>
       // Initialize arrays for table filter maps
       if (table_filters["<?php echo $table_name?>"] == null) {
           table_filters["<?php echo $table_name?>"] = {};
       }
       if (table_filter_elements["<?php echo $table_name?>"] == null)  {
           table_filter_elements["<?php echo $table_name?>"] = {};
       }
       // Store relevant data
       table_filters["<?php echo $table_name?>"]['<?php echo $div_name?>'] = ['<?php echo $filter -> default_value?>', false, '<?php echo $filter -> default_value?>'];
    </script>
    <div id = "<?php echo $div_name?>-group" class = "date-range-group"> 
       <div class="form-check">
           <input class="form-check-input" 
               type="checkbox" value="" 
               id="flexCheckDefault-<?php echo $div_name?>" 
               onClick = "toggle_filters('<?php echo $table_name?>', ['<?php echo $div_name?>'])">
           <label>Enable '<?php echo $cond_label ?>' Filter
           </label>
       </div>
       <div id = "<?php echo $div_name?>-form">
           <label for="text" class = "filter-label"><?php echo $cond_label?></label>
           <input type = "text" 
               class = "form-control filter-text" 
               id = "<?php echo $div_name?>" 
               name = "filter-text" 
               disabled
               onChange = "update_filter('<?php echo $div_name?>', '<?php echo $table_name?>', table_filters['<?php echo $table_name?>']['<?php echo $div_name?>'])">
       </div>
    </div>
    <?php
    return ob_get_clean();
}?>

<script>
// Initialize query links
var query_handler_url = '<?php echo $backup . $local_path_editor?>';
var table_generator_url = '<?php echo $backup . $local_path_editor?>';
// Initialize all table variables
var table_parents = {};
var table_qnames = {};
var table_codes = {};
var table_types = {};
var table_queries = {};
var table_mwidths = {};
var table_dependants = {};
var table_filters = {};
var table_filter_elements = {};
var table_field_types = {};
var table_opts = {};
var table_input_child_htmls= {};
</script>
