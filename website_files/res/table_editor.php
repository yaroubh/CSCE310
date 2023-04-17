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
    <div class = 'table-container table-sql-view' <?php echo $div_style?>>
        <table class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
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
    <div class = 'table-editor table-container table-sql-view' <?php echo $div_style?>>
        <table class = 'table table-hlimit border-black border-black-td table-hover table-light auto'>
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
                            <input id = "<?php echo $table_name . '-' . $i  . '-' . $j?>" 
                            value = "<?php echo $row[$j]; ?>" 
                            onChange = "updateTable(<?php echo "'" . $table_name . "', '" . $table_query_name . "', '" . $field->name . "', '" . $id_field . "', " . $row[0] . ", '" . $i . "', '" . $j . "'"?>);">
                    </td>
                    <?php }?>
                </tr>
                <?php } ?>
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
        $.ajax({type:'post', url:ajaxurl, data, success:
            function (response) {
                console.log(response);
            }
        });
    }
</script>

<?php
# echo generateTableView($conn, "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "500px");

?>