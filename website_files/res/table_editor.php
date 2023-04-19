<?php
# include "res/head.php"; 
function generate_editor_key_code($table_name, $table_query_name, $query) {
    $key_code = hash("md5", ":>EDIT-SELECT<:" . $table_name . ":>FROM<:" . str_repeat($table_query_name,2) . $query);
    return $key_code;
}

function generate_viewer_key_code($table_name, $table_query_name, $query) {
    $key_code = hash("md5", ":>VIEW-SELECT<:" . $table_name . ":>FROM<:" . str_repeat($table_query_name,2) . $query);
    return $key_code;
}

?>


<?php function generate_table_editable($parent_div, $table_name, $table_query_name, $query, $max_width) {
    // Generates an editable table
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

<?php function generate_table_view($parent_div, $table_name, $table_query_name, $query, $max_width) {
    // Generates an editable table
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

<script>
    var table_parents = {};
    var table_qnames = {};
    var table_codes = {};
    var table_types = {};
    var table_queries = {};
    var table_mwidths = {};
    var table_dependants = {};
    function update_table(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num, key_code) {
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let data =  {update_field: "update_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
        console.log(data);
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
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let data =  {get_field: "get_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
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

    function insert_row(table_name, table_query_name, field_name, id_field, num_fields, key_code) {
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let new_values = [];
        for (let i = 1; i < num_fields; i++) {
            new_values.push(document.getElementById(table_name + "-INSERT-" + i).value);
        }
        let data =  {insert_row: "get_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_values: JSON.stringify(new_values),
            key_code: key_code
        };
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
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let data =  {delete_row: "delete_row",
            table_query_name: table_query_name,
            field_name: field_name,
            id_field: id_field,
            id_value: id_value,
            key_code: key_code
        };
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
        var ajaxurl = "<?php echo $backup . 'res/table_generator.php'?>";
        let data =  {generate_table_viewable: "generate_table_viewable",
            table_name: table_name,
            table_query_name: table_query_name,
            query: query,
            key_code: key_code
        };
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                // console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
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
                                            <label>${curr_field_array[curr_field_array.length - 2]}</label>
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
                    let d_name = depedant_array[k];
                    if (table_types[d_name] == "editor") {
                        generate_table_editable(table_parents[d_name], table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else if (table_types[d_name] == "viewer") {
                        generate_table_view(table_parents[d_name], table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else {
                        console.log("Error! Invalid Table Type!");
                    }
                }
                
            }
        });

    }

    // Generates the html for an editable table
    function generate_table_editable(table_name, table_query_name, query, key_code, max_width) {
        var ajaxurl = "<?php echo $backup . 'res/table_generator.php'?>";
        let data =  {generate_table_editable: "generate_table_editable",
            table_name: table_name,
            table_query_name: table_query_name,
            query: query,
            key_code: key_code
        };
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                // console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] == "Success!") {
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
                    let d_name = depedant_array[k];
                    if (table_types[d_name] == "editor") {
                        generate_table_editable(table_parents[d_name], table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else if (table_types[d_name] == "viewer") {
                        generate_table_view(table_parents[d_name], table_qnames[d_name], table_queries[d_name], table_codes[d_name], table_mwidths[d_name]);
                    } else {
                        console.log("Error! Invalid Table Type!");
                    }
                }
                
            }
        });
    }

    
</script>

<?php
# echo generateTableView($conn, "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "500px");

?>