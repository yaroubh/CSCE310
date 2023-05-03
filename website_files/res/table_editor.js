


/**
 * This file handles the JavaScript required to display tables. Additionally it makes post requests to get the information from PHP for the tables
 */

/**
 * Updates a field in the table
 * 
 * @param {string} table_name ID of table
 * @param {string} table_query_name Name of table in query
 * @param {string} field_name Column name of field to be updated
 * @param {string} id_field ID field for table
 * @param {int} id_value The ID value for this update item
 * @param {int} row_num The row in the table for this field
 * @param {int} col_num The column in the table for this field
 */
function update_table(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num) {
    // Prepare post request
    var ajaxurl = query_handler_url;
    let div_name = table_name + "-" + row_num + "-" + col_num;
    let new_value = document.getElementById(div_name).value;
    let value_type = table_field_types[table_name][col_num - 1];
    // Make sure to set value as date if it's a date
    if (value_type.split("::")[0] == "datetime-local") {
        new_value = get_mysql_date(new_value);
    }
    // Make data object to send to post request
    let data =  {update_field: "update_field",
        table_name: table_name,
        table_query_name: table_query_name,
        field_name: field_name,
        new_value: new_value,
        id_field: id_field,
        id_value: id_value,
        col_num: col_num,
    };
    // console.log(data);
    // Launch post request via ajax
    $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
            // console.log(response);
            let parsed_resp = JSON.parse(response);
            // Add the warning to be made
            if (parsed_resp[0] == "mysqli_sql_exception") { 
                table_input_child_htmls[table_name][div_name] = `
                    <div class="alert alert-danger" role = "alert">
                        ${parsed_resp[1]}
                    </div>
                `;
            } else {
                // No warning by default
                table_input_child_htmls[table_name][div_name] = '';
            }
            // We need to refix the field
            regenerate_table(table_name);
        }
    });
}

/**
 * Regenerates a table
 * 
 * @param {string} table_name ID of table
 */
function regenerate_table(table_name) {
    if (table_types[table_name] == "editor") {
        generate_table_editable(table_name, table_qnames[table_name], table_mwidths[table_name]);
    } else if (table_types[table_name] == "viewer") {
        generate_table_view(table_name, table_qnames[table_name], table_mwidths[table_name]);
    } else {
        console.log("Error! Invalid Table Type!");
    }
}

/**
 * Inserts a row into the table
 * 
 * @param {string} table_name ID of table
 * @param {string} table_query_name Name of table in query
 * @param {string} field_name Column name of field to be updated
 * @param {int} num_fields The number of fields (excluding ID) that are part of the entity
 */
function insert_row(table_name, table_query_name, field_name, num_fields) {
    // Prepare post request
    var ajaxurl = query_handler_url;
    let new_values = [];
    // Get all values of the current row and save them to an array
    for (let i = 1; i < num_fields; i++) {
        let new_value = document.getElementById(table_name + "-INSERT-" + i).value;
        let value_type = table_field_types[table_name][i - 1];
        // Make sure to set value as date if it's a date
        if (value_type.split("::")[0] == "datetime-local") {
            new_value = get_mysql_date(new_value);
        }
        new_values.push(new_value);
    }
    // Make data object to send to post request
    let data =  {insert_row: "get_field",
        table_name: table_name,
        table_query_name: table_query_name,
        field_name: field_name,
        new_values: JSON.stringify(new_values)
    };
    // Launch post request via ajax
    $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
            console.log(response);
            let parsed_resp = JSON.parse(response);
            if (parsed_resp[0] == "mysqli_sql_exception") { 
                // Make an error message
                table_input_child_htmls[table_name][table_name] = `
                    <div class="alert alert-danger" role = "alert">
                        ${parsed_resp[1]}
                    </div>
                `;
                update_table_input_child_htmls(table_name);
            } else if (parsed_resp == "Success!") {
                // No warning by default
                table_input_child_htmls[table_name][table_name] = '';
            }
            regenerate_table(table_name);
        }
    });
}

/**
 * Deletes a row in the table
 * 
 * @param {string} table_name ID of table
 * @param {string} table_query_name Name of table in query
 * @param {string} field_name Column name of field to be updated
 * @param {string} id_field ID field for table
 * @param {int} id_value The ID value for this update item
 */
function delete_row(table_name, table_query_name, field_name, id_field, id_value) {
    // Prepare post request
    var ajaxurl = query_handler_url;
    // Make data object to send to post request
    let data =  {delete_row: "delete_row",
        table_query_name: table_query_name,
        field_name: field_name,
        id_field: id_field,
        id_value: id_value,
    };
    // Launch post request via ajax
    $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
            console.log(response);
            let parsed_resp = JSON.parse(response);
            if (parsed_resp[0] == "Success!") {
                regenerate_table(table_name);
            }
        }
    });
}

/**
 * Updates the input children htmls of a table - useful for displaying error messages on inputs
 * 
 * @param {string} table_name ID of table element
 */
function update_table_input_child_htmls(table_name) {
    // Update necessary input elements
    let input_field_child_htmls = table_input_child_htmls[table_name];
    Object.keys(input_field_child_htmls).forEach(function(key, index) {
        let curr_field_html = input_field_child_htmls[key];
        if (curr_field_html != "") {
            // Add the child html
            console.log("Inserting html for " + key);
            document.getElementById(key).insertAdjacentHTML("afterend", curr_field_html);
        }
    });
}

/**
 * Generates the html for a viewable table 
 * 
 * @param {string} table_name ID of table
 * @param {string} table_query_name Name of table in query
 * @param {string} max_width The maximum width of the table, or "Inf" if not constrained
 */
function generate_table_view(table_name, table_query_name, max_width) {
    // Prepare post request
    var ajaxurl = table_generator_url;
    // Make data object to send to post request
    let data =  {generate_table_viewable: "generate_table_viewable",
        table_name: table_name,
        table_query_name: table_query_name
    };
    // Add filter elements if need be
    if (table_filters[table_name] != null) {
        let filters_object = table_filters[table_name];
        let filters = [];
        Object.keys(filters_object).forEach(function(key, index) {
            let curr_filter = filters_object[key];
            // Only add current filter if the filter flag is enabled
            if (curr_filter[1] == true) {
                // Generate the filter to send
                // 1st parameter -> Filter ID
                // 2nd parameter -> Table ID
                // 3rd parameter -> Fitler Value
                let send_filter = [key, table_name, curr_filter[0]];
                filters.push(send_filter);
            }
        });

        if (filters.length > 0) {
            data["filters"] = JSON.stringify(filters);
        }
    }
    // Launch post request via ajax
    $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
            // console.log(response);
            let parsed_resp = JSON.parse(response);
            if (parsed_resp[0] == "Success!") {
                // console.log("Making table view");
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
                regenerate_table(d_name);
            }
            
        }
    });

}

/**
 * Generates the html for an editable table 
 * 
 * @param {string} table_name ID of table
 * @param {string} table_query_name Name of table in query
 * @param {string} max_width The maximum width of the table, or "Inf" if not constrained
 */
function generate_table_editable(table_name, table_query_name, max_width) {
    // Prepare Post Request
    var ajaxurl = table_generator_url;
    // Make data object to send to post request
    let data =  {generate_table_editable: "generate_table_editable",
        table_name: table_name,
        table_query_name: table_query_name
    };
    // console.log(ajaxurl);
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
                // Get the input field types
                let input_field_types = table_field_types[table_name];
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
                            let curr_field_type = input_field_types[j - 1];
                            let curr_field_type_parts = curr_field_type.split("::");
                            let on_change_text = `update_table('${table_name}', '${table_query_name}', '${curr_field_array[2]}',  '${id_field}',  '${curr_field_array[4]}',  '${i}',  '${j}');`;
                            // Sync the date fields if need be or handle any constraints
                            if (curr_field_type_parts[0] == "datetime-local") {
                                if (curr_field_type_parts.length > 1) {
                                    let constraint = curr_field_type_parts[1];
                                    if (constraint == "start") {
                                        on_change_text = `make_dates_consistent('${table_name}-INSERT-${j}', null, '${table_name}-INSERT-${j + 1}');` + on_change_text;
                                    } else if (constraint == "end") {
                                        on_change_text = `make_dates_consistent('${table_name}-INSERT-${j}', '${table_name}-INSERT-${j - 1}', null);` + on_change_text;
                                    }
                                }
                            }
                            html_string += `
                                    <td>
                                        <input id = "${table_name}-${i}-${j}" 
                                            type = "${input_field_types[j - 1].split("::")[0]}"
                                            value = "${curr_field_array[curr_field_array.length - 1]}"  
                                            onChange = "${on_change_text}">
                                    </td>
                            `;
                        } else {
                            let curr_field_array = curr_row_array[j];
                            html_string += `
                                    <td>
                                        <label>${curr_row_array[j][0]}</label>
                                        <button onClick = "delete_row('${table_name}', '${table_query_name}', '${field_array[j]}',  '${id_field}',  '${curr_field_array[0]}')">X</button>
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
                        let curr_field_type = input_field_types[j - 1];
                        let curr_field_type_parts = curr_field_type.split("::");
                        let on_change_text = "";
                        // Sync the date fields if need be or handle any constraints
                        if (curr_field_type_parts[0] == "datetime-local") {
                            if (curr_field_type_parts.length > 1) {
                                let constraint = curr_field_type_parts[1];
                                if (constraint == "start") {
                                    on_change_text = `onChange = "make_dates_consistent('${table_name}-INSERT-${j}', null, '${table_name}-INSERT-${j + 1}');"`;
                                } else if (constraint == "end") {
                                    on_change_text = `onChange = "make_dates_consistent('${table_name}-INSERT-${j}', '${table_name}-INSERT-${j - 1}', null);"`;
                                }
                            }
                        }
                        html_string += `
                                    <td>
                                        <input type = "${input_field_types[j - 1].split("::")[0]}" id = "${table_name}-INSERT-${j}"  ${on_change_text}>
                                    </td>
                        `;
                    } else {
                        html_string += `
                                    <td>
                                        <button onClick="insert_row('${table_name}',  '${table_query_name}', '${field_array[j]}', '${id_field}', '${field_array.length}');">Add Row</button>
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

                update_table_input_child_htmls(table_name);
            }
            // Reload all dependants
            let dependent_array = table_dependants[table_name];
            if (dependent_array == null) {
                return;
            }
            for (let k = 0; k < dependent_array.length; k++) {
                // Make all dependents now
                let d_name = dependent_array[k];
                regenerate_table(d_name);
            }
    
            
        }
    });
}


/**
 * Toggles each filter in the filter array parameter to enable or disable it
 * 
 * @param {string} table_name ID of table element
 * @param {string[]} filter_array List of strings corresponding to filter elements
 */
function toggle_filters(table_name, filter_array) {
    // Toggle each filter
    for (let i = 0; i < filter_array.length; i++) {
        let curr_elem_name = filter_array[i];
        let curr_elem = document.getElementById(curr_elem_name);
        curr_elem.disabled = !curr_elem.disabled;
        table_filters[table_name][curr_elem_name][1] = !table_filters[table_name][curr_elem_name][1];
    }
    // Update table
    regenerate_table(table_name);
}

/**
 * Pulls the text from an input field, and updates the appropriate table
 * 
 * @param {string} div_name ID of the input date field
 * @param {string} table_name ID of table that the field affects
 * @param {array} filter_array array of elements that contains the filter options
 */
function update_filter(div_name, table_name, filter_array) {
    let val = document.getElementById(div_name).value;
    // Convert date from js format to MySQL format
    // Update the filter value
    filter_array[0] = val;
    // Update the table
    regenerate_table(table_name);

}

/**
 * Converts a js date to a MySQL date
 * 
 * @param {string} date_text js formatting of a date
 * @return {string} MySQL formmating of a date
 */
function get_mysql_date(date_text) {
    let mysql_date_value = new Date(date_text);
    let offset = mysql_date_value.getTimezoneOffset() * 60 * 1000;
    mysql_date_value = new Date(mysql_date_value - offset).toISOString().split(".")[0].replace('T', ' ');
    return mysql_date_value;
}

/**
 * Makes a date element consistent with a start date element and/or an end date element
 * @param {string} div_name ID of the input date field
 * @param {string?} start_date_element ID of field that handles starting date (div_name would be end date), null if N/A
 * @param {string?} end_date_element ID of field that handles ending date (div_name would be start date), null if N/A
 */
function make_dates_consistent(div_name, start_date_element, end_date_element) {
    let date_value = document.getElementById(div_name).value;

    // Make sure current date is after or equal to start date
    if (start_date_element != null) {
        let start_date_value  = document.getElementById(start_date_element).value;
        if (start_date_value != '' && start_date_value > date_value) {
            document.getElementById(div_name).value = start_date_value;
        }
    }
    // Make sure current date is before or equal to end date
    if (end_date_element != null) {
        let end_date_value  = document.getElementById(end_date_element).value;
        if (end_date_value != '' && end_date_value < date_value) {
            document.getElementById(div_name).value = end_date_value;
        }
    }
}

/**
 * Pulls the date from an input date field, and updates the appropriate table
 * 
 * @param {string} div_name ID of the input date field
 * @param {string?} start_date_element ID of field that handles starting date (div_name would be end date), null if N/A
 * @param {string?} end_date_element ID of field that handles ending date (div_name would be start date), null if N/A
 * @param {string} table_name ID of table that the field affects
 * @param {array} filter_array array of elements that contains the filter options
 */
function update_date(div_name, start_date_element, end_date_element, table_name, filter_array) {
    console.log(div_name + " " + start_date_element + " " + end_date_element);
    make_dates_consistent(div_name, start_date_element, end_date_element)
    let date_value = document.getElementById(div_name).value;

    // Make sure current date is after or equal to start date
    if (start_date_element != null) {
        let start_date_value  = document.getElementById(start_date_element).value;
        if (start_date_value > date_value) {
            document.getElementById(div_name).value = start_date_value;
            date_value = start_date_value;
        }
    }
    // Make sure current date is before or equal to end date
    if (end_date_element != null) {
        let end_date_value  = document.getElementById(end_date_element).value;
        if (end_date_value < date_value) {
            document.getElementById(div_name).value = end_date_value;
            date_value = end_date_value;
        }
    }

    // Convert date from js format to MySQL format
    let mysql_date_value = get_mysql_date(date_value);


    // Update the filter value
    filter_array[0] = mysql_date_value;
    // Update the table
    regenerate_table(table_name);

}
