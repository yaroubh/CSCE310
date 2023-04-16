<?php
include "res/head.php"; 


?>

<?php function generateTableView($conn, $query, $max_width) {
    ob_start();
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt -> get_result();
    # Generate the table header row
    $field_count = 0;
    $field_array = array();
    $div_style = "";
    if ($max_width != "Infinity" || $max_width != "Inf") {
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
                    <?php for($i=0; $field = array_pop($field_array); $i++){
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

<?php
echo generateTableView($conn, "SELECT * FROM Hotel ORDER BY Hotel_ID ASC", "500px");

?>