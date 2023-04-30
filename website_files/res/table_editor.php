<?php
# include "res/head.php"; 
// Generate a key code for an editable table
// A Key Code prevents post request forgery as the correct key code must be used with an SQL Query otherwise the server will reject the request
function generate_editor_key_code($table_name, $table_query_name, $query) {
    $key_code = hash("md5", ":>EDIT-SELECT<:" . $table_name . ":>FROM<:" . str_repeat($table_query_name,2) . $query);
    return $key_code;
}

// Generates a key code for a non-editable table
// A Key Code prevents post request forgery as the correct key code must be used with an SQL Query otherwise the server will reject the request
function generate_viewer_key_code($table_name, $table_query_name, $query) {
    $key_code = hash("md5", ":>VIEW-SELECT<:" . $table_name . ":>FROM<:" . str_repeat($table_query_name,2) . $query);
    return $key_code;
}

// Generates a key code for a filter
// A Key Code prevents post request forgery as the correct key code must be used with an SQL Query otherwise the server will reject the request
function generate_filter_key_code($cond_text_start, $cond_op, $cond_text_end, $cond_type) {
    $key_code = hash("md5", "||KEY_CODE||" . $cond_text_start . str_repeat($cond_op, 3) . $cond_type . $cond_text_end .  "-KC");
    return $key_code;
}
?>


<?php
// Generates an editable table
function generate_table_editable($parent_div, $table_name, $table_query_name, $query, $max_width, $table_field_types, $table_opts) {

    // Buffer the output so we can store it
    ob_start();
    $key_code = generate_editor_key_code($table_name, $table_query_name, $query);
    ?>
    <script>
        // Store relevant data
        table_parents["<?php echo $table_name?>"] = document.getElementById("<?php echo $parent_div?>");
        table_qnames["<?php echo $table_name?>"] = "<?php echo $table_query_name?>";
        table_codes["<?php echo $table_name?>"] = "<?php echo $key_code?>";
        table_types["<?php echo $table_name?>"] = "editor";
        table_queries["<?php echo $table_name?>"] = "<?php echo $query?>";
        table_mwidths["<?php echo $table_name?>"] = "<?php echo $max_width?>";
        table_field_types["<?php echo $table_name?>"] = JSON.parse('<?php echo json_encode($table_field_types)?>');
        table_input_child_htmls["<?php echo $table_name?>"] = {};
        // Generate the table
        generate_table_editable("<?php echo $table_name?>", "<?php echo $table_query_name?>", "<?php echo $query?>", "<?php echo $key_code?>", "<?php echo $max_width?>");
    </script>
    <?php
    return ob_get_clean();
}?>

<?php
// Generates a non-editable table
function generate_table_view($parent_div, $table_name, $table_query_name, $query, $max_width) {

    // Buffer the output so we can store it
    ob_start();
    $key_code = generate_viewer_key_code($table_name, $table_query_name, $query);
    ?>
    <script>
        // Store relevant data
        table_parents["<?php echo $table_name?>"] = document.getElementById("<?php echo $parent_div?>");
        table_qnames["<?php echo $table_name?>"] = "<?php echo $table_query_name?>";
        table_codes["<?php echo $table_name?>"] = "<?php echo $key_code?>";
        table_types["<?php echo $table_name?>"] = "viewer";
        table_queries["<?php echo $table_name?>"] = "<?php echo $query?>";
        table_mwidths["<?php echo $table_name?>"] = "<?php echo $max_width?>";
        // Generate the table
        generate_table_view("<?php echo $table_name?>", "<?php echo $table_query_name?>", "<?php echo $query?>", "<?php echo $key_code?>", "<?php echo $max_width?>");
    </script>
    <?php
    return ob_get_clean();
}?>

<?php

/**
 * Generates a date range filter for a table
 *
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
function generate_date_range_filter($div_name, $table_name, $sd_cond_name_start, $sd_cond_name_end, $ed_cond_name_start, $ed_cond_name_end, $cond_label, $default_start, $default_end) {
    // Buffer the output so we can store it
    ob_start();
    $key_code_start = generate_filter_key_code($sd_cond_name_start, ">", $sd_cond_name_end, "s");
    $key_code_end = generate_filter_key_code($ed_cond_name_start, "<", $ed_cond_name_end, "s");
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
        table_filters["<?php echo $table_name?>"]['<?php echo $div_name . "-start" ?>'] = ['<?php echo $sd_cond_name_start?>', '>',
            's', '<?php echo $default_start?>', '<?php echo $sd_cond_name_end?>', '<?php echo $key_code_start?>', true, '<?php echo $default_start?>'];
        table_filters["<?php echo $table_name?>"]['<?php echo $div_name . "-end" ?>'] = ['<?php echo $ed_cond_name_start?>', '<',
            's', '<?php echo $default_end?>', '<?php echo $ed_cond_name_end?>', '<?php echo $key_code_end?>', true, '<?php echo $default_end?>'];
        table_filter_elements["<?php echo $table_name?>"]['<?php echo $div_name?>'] = [2];
    </script>
    <div id = "<?php echo $div_name?>-group" class = "date-range-group"> 
        <div class="form-check">
            <input class="form-check-input" 
                type="checkbox" value="" 
                id="flexCheckDefault-<?php echo $div_name?>" 
                onClick = "toggle_filters('<?php echo $table_name?>', ['<?php echo $div_name . "-start" ?>', '<?php echo $div_name . "-end" ?>'])"
                checked>
            <label>Enable '<?php echo $cond_label ?>' Date Range
            </label>
        </div>
        <div id = "<?php echo $div_name?>-form">
            <label for="date_time" class = "date-range-label"><?php echo $cond_label?></label>
            <input type = "datetime-local" 
                class = "form-control date-range-filter" 
                id = "<?php echo $div_name . "-start" ?>" 
                name = "date_time" 
                value = "<?php echo $default_start?>"
                onChange = "update_date('<?php echo $div_name?>-start', null,'<?php echo $div_name?>-end', '<?php echo $table_name?>', table_filters['<?php echo $table_name?>']['<?php echo $div_name . "-start" ?>'])">
            <p class = "date-range-text"> to </p>
            <input type = "datetime-local"
                class = "form-control date-range-filter" 
                id = "<?php echo $div_name . "-end"?>" name="date_time"
                value = "<?php echo $default_end?>"
                onChange = "update_date('<?php echo $div_name?>-end', '<?php echo $div_name?>-start', null, '<?php echo $table_name?>', table_filters['<?php echo $table_name?>']['<?php echo $div_name . "-end" ?>'])">
        </div>
    </div>
    <?php
    return ob_get_clean();
}?>

<?php
// Generates a search filter for a table

function generate_search_filter($div_name, $table_name, $cond_name_start, $cond_op, $cond_name_end, $cond_type, $cond_label) {
   // Buffer the output so we can store it
   ob_start();
   $key_code = generate_filter_key_code($cond_name_start, $cond_op, $cond_name_end, $cond_type);
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
       table_filters["<?php echo $table_name?>"]['<?php echo $div_name?>'] = ['<?php echo $cond_name_start?>', '<?php echo $cond_op?>',
           '<?php echo $cond_type?>', '', '<?php echo $cond_name_end?>', '<?php echo $key_code?>', false, ''];
       table_filter_elements["<?php echo $table_name?>"]['<?php echo $div_name?>'] = [1];
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
var query_handler_url = '<?php echo $backup . 'res/query_handler.php'?>';
var table_generator_url = '<?php echo $backup . 'res/table_generator.php'?>';
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
var table_input_child_htmls= {};
</script>
