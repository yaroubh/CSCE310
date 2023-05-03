<?php 
include "table_dropper.php";
// We need to remake the connection due to the way multi_query works
$conn -> close();
$conn = make_connection();
include "table_maker.php";
include "table_initializer.php";
?>