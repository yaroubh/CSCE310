<?php
# include "res/head.php"; 


?>


<?php function generateTableView($conn, $table_name, $table_query_name, $query, $max_width) {
    # Creates uneditable table view
    ob_start();
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt -> get_result();
    # Generate the table header row
    $field_count = 0;
    $field_array = array();
    $div_style = "";
    if ($max_width != "Infinity" && $max_width != "Inf") {
        $div_style = "style= 'width : " . $max_width . ";'";
    }
    ?>
    <div id = '<?php echo $table_name?>-div' class = 'table-editor table-container table-sql-view' <?php echo $div_style?>>
        <table id = '<?php echo $table_name?>' class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
            <thead>
                <tr>
                    <?php for($i=0; $field = $result->fetch_field(); $i++){
                        # Add field to front of array
                        array_unshift($field_array, $field);
                        ?>
                        <th><?php echo $field->name ?></th>
                    <?php } ?>
                </tr>
            </thead>
        <?php for($i=0; $row = $result->fetch_row(); $i++){
            # Go through and display the rest of the rows and
            # the attribute values for each entity
            ?>
                <tr>
                    <?php
                    $field_array_copy = $field_array;
                    for($i=0; $field = array_pop($field_array_copy); $i++){
                        # echo $field -> name;
                        ?>
                        <td><label><?php echo $row[$i]; ?></label></td>
                    <?php }?>
                </tr>
                <?php } ?>
        </table>
    </div>
<?php
    return ob_get_clean();
} ?>

<?php function generateTableEditable($conn, $table_name, $table_query_name, $query, $max_width) {
    # Creates uneditable table view
    ob_start();
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt -> get_result();
    # Generate the table header row
    $field_count = 0;
    $field_array = array();
    $div_style = "";
    $id_field = "";
    if ($max_width != "Infinity" && $max_width != "Inf") {
        $div_style = "style= 'width : " . $max_width . ";'";
    }
    ?>
    <div id = '<?php echo $table_name?>-div' class = 'table-editor table-container table-sql-view' <?php echo $div_style?>>
        <table id = '<?php echo $table_name?>' class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
            <thead>
                <tr>
                    <?php for($i=0; $field = $result->fetch_field(); $i++){
                        if ($i == 0) {
                            # store the id field
                            $id_field = $field->name;
                        }
                        # Add field to front of array
                        array_unshift($field_array, $field);
                        ?>
                        <th><?php echo $field->name ?></th>
                    <?php } ?>
                </tr>
            </thead>
        <tbody id = '<?php echo $table_name?>-tbody'>
        <?php for($i=0; $row = $result->fetch_row(); $i++){
            # Go through and display the rest of the rows and
            # the attribute values for each entity
            ?>
                <tr>
                    <?php
                    $field_array_copy = $field_array;
                    for($j=0; $field = array_pop($field_array_copy); $j++){
                        # echo $field -> name;
                        ?>
                        <td>
                            <?php if ($j != 0) {
                                # We only want the non-primary key columns to be editable.
                                ?>
                            <input id = "<?php echo $table_name . '-' . $i  . '-' . $j?>" 
                            value = "<?php echo $row[$j]; ?>" 
                            onChange = "updateTable(<?php echo "'" . $table_name . "', '" . $table_query_name . "', '" . $field->name . "', '" . $id_field . "', " . $row[0] . ", '" . $i . "', '" . $j . "'"?>);">
                            <?php } else { 
                                ?>
                                <label><?php echo $row[$j]; ?></label>
                            <?php } ?>
                    </td>
                    <?php }?>
                </tr>
                <?php } ?>
                <tr>
                    <?php 
                        $field_array_copy = $field_array;
                        for($j=0; $field = array_pop($field_array_copy); $j++){
                            # Go through and add the fields for insertion!
                            if ($j != 0) {
                            ?>

                            <td>
                                <input id = "<?php echo $table_name . '-INSERT-' . $j?>">
                            </td>
                            <?php } else { ?>
                                <td>
                                    <button onClick="console.log('click');">Add Row</button>
                                </td>
                            <?php } ?>
                    <?php } ?>
                </tr>
            </tbody>
        </table>
    </div>
<?php
    return ob_get_clean();
} ?>

<script>
    function updateTable(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num) {
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let data =  {update_field: "update_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value
        };
        $.ajax({type:'post', url:ajaxurl, data, success:function (response) {
                console.log(response);
                let parsed_resp = JSON.parse(response);
                if (parsed_resp[0] != "Success!") {

                }
                // We need to refix the field
                getField(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num);
            }
        });
    }

    // Updates a field in the table - useful for checking to see if update went through
    function getField(table_name, table_query_name, field_name, id_field, id_value, row_num, col_num) {
        var ajaxurl = "<?php echo $backup . 'res/query_handler.php'?>";
        let data =  {get_field: "get_field",
            table_query_name: table_query_name,
            field_name: field_name,
            new_value: document.getElementById(table_name + "-" + row_num + "-" + col_num).value,
            id_field: id_field,
            id_value: id_value
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
</script>

<?php
# echo generateTableView($conn, "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "500px");

?>