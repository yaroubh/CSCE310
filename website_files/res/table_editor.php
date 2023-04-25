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
function generate_table_editable($parent_div, $table_name, $table_query_name, $query, $max_width) {

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
    <div id = <?php echo $div_name?>>
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
    <?php
    return ob_get_clean();
}?>

<?php
// Generates a search filter for a table
/**
 * @param parent_div
 */
function generate_search_filter($parent_div, $div_name, $table_name, $cond_name, $default_start, $default_end) {
    // Buffer the output so we can store it
    ob_start();
    $key_code = generate_viewer_key_code($table_name, $table_query_name, $query);
    ?>
    <script>
        // Initialize arrays for table filter maps
        if (table_filters["<?php echo $table_name?>"] == null) {
            table_filters["<?php echo $table_name?>"] = [];
        }
        if (table_filters_elements["<?php echo $table_name?>"] == null)  {
            table_filters_elements["<?php echo $table_name?>"] = [];
        }
        // Store relevant data
        table_filters["<?php echo $table_name?>"].push(['<?php echo $cond_name?>' + '-START', '<?php echo $cond_op?>',
            '<?php echo $cond_type?>', '<?php echo $default_start?>', '<?php echo $key_code?>']);
        table_filters["<?php echo $table_name?>"].push(['<?php echo $cond_name?>' + '-END', '<?php echo $cond_op?>',
            '<?php echo $cond_type?>', '<?php echo $default_start?>', '<?php echo $key_code?>']);
        table_filter_elements["<?php echo $table_name?>"].push(['', 2]);
        table_codes["<?php echo $table_name?>"] = "<?php echo $key_code?>";
        table_types["<?php echo $table_name?>"] = "viewer";
        table_queries["<?php echo $table_name?>"] = "<?php echo $query?>";
        table_mwidths["<?php echo $table_name?>"] = "<?php echo $max_width?>";
        // Generate the table
        // generate_table_view("<?php echo $table_name?>", "<?php echo $table_query_name?>", "<?php echo $query?>", "<?php echo $key_code?>", "<?php echo $max_width?>");
    </script>
    <?php
    return ob_get_clean();
}?>

<script>
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

    // Updates a field in a table
    function update_table(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num, key_code) {
        // Prepare post request
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        // Make data object to send to post request
        let data =  {update_field: "update_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] != "Success!") {

                }
                // We need to refix the field
                get_field(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num, key_code);
            }
        });
    }

    // Updates a field in the table - useful for checking to see if update went through
    function get_field(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num, key_code) {
        // Prepare post request
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        // Make data object to send to post request
        let data =  {get_field: "get_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
                    let data_array = parsed_resp[1];
                    let data_value = data_array[0][field_name];
                    document.getElementById(table_name + "-" + row_num + "-" + col_num).value = data_value;
                }
            }
        });
    }

    // Inserts a row into the table
    function insert_row(table_name, table_query_name, field_name, id_field, num_fields, key_code) {
        // Prepare post request
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let new_values = [];
        // Get all values of the current row and save them to an array
        for (let i = 1; i < num_fields; i++) {
            new_values.push(document.getElementById(table_name + "-INSERT-" + i).value);
        }
        // Make data object to send to post request
        let data =  {insert_row: "get_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_values: JSON.stringify(new_values),
            key_code: key_code
        };
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
                    generate_table_editable(table_name, table_query_name, table_queries[table_name], table_codes[table_name], table_mwidths[table_name]);
                }
            }
        });
    }

    // Deletes a row in a table
    function delete_row(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num, key_code) {
        // Prepare post request
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        // Make data object to send to post request
        let data =  {delete_row: "delete_row",
            table_query_name: table_query_name,
            field_name: field_name,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
                    generate_table_editable(table_name, table_query_name, table_queries[table_name], table_codes[table_name], table_mwidths[table_name]);
                }
            }
        });
    }

    // Generates the html for a viewable table
    function generate_table_view(table_name, table_query_name, query, key_code, max_width) {
        // Prepare post request
        var ajaxurl = "<?php echo $backup . 'res/table_generator.php'?>";
        // Make data object to send to post request
        let data =  {generate_table_viewable: "generate_table_viewable",
            table_name: table_name,
            table_query_name: table_query_name,
            query: query,
            key_code: key_code
        };
        // Add filter elements if need be
        if (table_filters[table_name] != null) {
            let filters_object = table_filters[table_name];
            let filters = [];
            Object.keys(filters_object).forEach(function(key, index) {
                let curr_filter = filters_object[key];
                // Only add current filter if the filter flag is enabled
                if (curr_filter[6] == true) {
                    // Generate the filter to send
                    let send_filter = [curr_filter[0], curr_filter[1], curr_filter[4], curr_filter[2], curr_filter[3], curr_filter[5]];
                    filters.push(send_filter);
                }
            });

            if (filters.length > 0) {
                data["filters"] = JSON.stringify(filters);
            }
        }
        console.log(data);
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
                    console.log("Making table view");
                    // Get the arrays
                    let data_array = parsed_resp[1];
                    let field_array = data_array[0];
                    let row_array = data_array[1];
                    let insert_array = data_array[2];
                    let html_string = "";
                    // Setup max width
                    let div_style = "";
                    if (max_width != "Infinity" && max_width != "Inf") {
                        div_style = "style= 'width : " + max_width + ";'";
                    }
                    // Generate HTML for table
                    html_string += `    
                    <div id = '${table_name}-div' class = 'table-editor table-container table-sql-view' ${div_style}>
                        <table id = '${table_name}' class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
                            <thead>
                                <tr>
                    `;
                    // Get each header (field name)
                    let id_field = field_array[0];
                    for (let i = 0; i < field_array.length; i++) {
                        html_string += `
                                    <th>${field_array[i]}</th>
                        `;
                    }
                    html_string += `
                                </tr>
                            </thead>
                            <tbody id = '${table_name}-tbody'>
                            `;
                    // Loop through each data row
                    for (let i = 0; i < row_array.length; i++) {
                        html_string += `
                                <tr id = '${table_name}-${i}-tr'>
                        `;
                        let curr_row_array = row_array[i];
                        // console.log(curr_row_array);
                        // Generate current data row
                        for (let j = 0; j < curr_row_array.length; j++) {
                            let curr_field_array = curr_row_array[j];
                            html_string += `
                                        <td>
                                            <label>${curr_field_array[curr_field_array.length - 1]}</label>
                                        </td>
                            `;
                        }
                    }
                    html_string += `
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `;
                    let parent_element = table_parents[table_name];
                    parent_element.innerHTML = html_string;
                }
                // Reload all dependants
                let dependant_array = table_dependants[table_name];
                if (dependant_array == null) {
                    return;
                }
                for (let k = 0; k < dependant_array.length; k++) {
                    // Make all dependents now
                    let d_name = depedant_array[k];
                    if (table_types[d_name] == "editor") {
                        generate_table_editable(d_name, table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else if (table_types[d_name] == "viewer") {
                        generate_table_view(d_name, table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else {
                        console.log("Error! Invalid Table Type!");
                    }
                }
                
            }
        });

    }

    // Generates the html for an editable table
    function generate_table_editable(table_name, table_query_name, query, key_code, max_width) {
        // Prepare Post Request
        var ajaxurl = "<?php echo $backup . 'res/table_generator.php'?>";
        // Make data object to send to post request
        let data =  {generate_table_editable: "generate_table_editable",
            table_name: table_name,
            table_query_name: table_query_name,
            query: query,
            key_code: key_code
        };
        // Launch post request via ajax
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                // console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
                    // Get the arrays
                    let data_array = parsed_resp[1];
                    let field_array = data_array[0];
                    let row_array = data_array[1];
                    let insert_array = data_array[2];
                    // Generate HTML for table
                    let html_string = "";
                    // Setup max width
                    let div_style = "";
                    if (max_width != "Infinity" && max_width != "Inf") {
                        div_style = "style= 'width : " + max_width + ";'";
                    }
                    html_string += `    
                    <div id = '${table_name}-div' class = 'table-editor table-container table-sql-view' ${div_style}>
                        <table id = '${table_name}' class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
                            <thead>
                                <tr>
                    `;
                    // Get each header (field name)
                    let id_field = field_array[0];
                    for (let i = 0; i < field_array.length; i++) {
                        html_string += `
                                    <th>${field_array[i]}</th>
                        `;
                    }
                    html_string += `
                                </tr>
                            </thead>
                            <tbody id = '${table_name}-tbody'>
                            `;
                    // Loop through each data row
                    for (let i = 0; i < row_array.length; i++) {
                        html_string += `
                                <tr id = '${table_name}-${i}-tr'>
                        `;
                        let curr_row_array = row_array[i];
                        // console.log(curr_row_array);
                        // Generate current data row
                        for (let j = 0; j < curr_row_array.length; j++) {
                            if (j != 0) {
                                let curr_field_array = curr_row_array[j];
                                html_string += `
                                        <td>
                                            <input id = "${table_name}-${i}-${j}" 
                                                value = "${curr_field_array[curr_field_array.length - 2]}"  
                                                onChange = "update_table('${table_name}', '${table_query_name}', '${curr_field_array[2]}',  '${id_field}',  '${curr_field_array[4]}',  '${i}',  '${j}', '${curr_field_array[curr_field_array.length - 1]}');">
                                        </td>
                                `;
                            } else {
                                let curr_field_array = curr_row_array[j];
                                html_string += `
                                        <td>
                                            <label>${curr_row_array[j][0]}</label>
                                            <button onClick = "delete_row('${table_name}', '${table_query_name}', '${field_array[j]}',  '${id_field}',  '${curr_field_array[0]}',  '${i}',  '${j}', '${curr_field_array[1]}')">X</button>
                                        </td>
                                `;
                            }
                        }
                    }
                    html_string += `
                                    </tr>
                                    <tr id = '${table_name}-insert-tr'>
                    `;
                    // Go through and make the insertion row
                    for (let j = 0; j < field_array.length; j++) {
                        if (j != 0) {
                            html_string += `
                                        <td>
                                            <input id = "${table_name}-INSERT-${j}">
                                        </td>
                            `;
                        } else {
                            html_string += `
                                        <td>
                                            <button onClick="insert_row('${table_name}',  '${table_query_name}', '${field_array[j]}', '${id_field}', '${field_array.length}', '${insert_array[insert_array.length - 1]}');">Add Row</button>
                                        </td>
                            `;
                        }
                    }
                    // Add the last part of the html string
                    html_string += `
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `;
                    let parent_element = table_parents[table_name];
                    parent_element.innerHTML = html_string;
                }
                // Reload all dependants
                let dependant_array = table_dependants[table_name];
                if (dependant_array == null) {
                    return;
                }
                for (let k = 0; k < dependant_array.length; k++) {
                    // Make all dependents now
                    let d_name = depedant_array[k];
                    if (table_types[d_name] == "editor") {
                        generate_table_editable(d_name, table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else if (table_types[d_name] == "viewer") {
                        generate_table_view(d_name, table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else {
                        console.log("Error! Invalid Table Type!");
                    }
                }
                
            }
        });
    }


    // Pulls the date from an input date field, and updates the appropriate table
    function update_date(div_name, start_date_element, end_date_element, table_name, filter_array) {
        let date_value = document.getElementById(div_name).value;
        // Convert date from js format to MySQL format
        let mysql_date_value = new Date(date_value);
        let offset = mysql_date_value.getTimezoneOffset() * 60 * 1000;
        mysql_date_value = new Date(mysql_date_value - offset).toISOString().split(".")[0].replace('T', ' ');

        filter_array[3] = mysql_date_value;
        if (table_types[table_name] == "editor") {
            generate_table_editable(table_name, table_qnames[table_name], table_queries[table_name], table_codes[table_name], table_mwidths[table_name]);
        } else if (table_types[table_name] == "viewer") {
            generate_table_view(table_name, table_qnames[table_name], table_queries[table_name], table_codes[table_name], table_mwidths[table_name]);
        } else {
            console.log("Error! Invalid Table Type!");
        }

    }
    
</script>

<?php
# echo generateTableView($conn, "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "500px");

?>