<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file drops all tables, remakes them, and initializes them with data.
It includes table_dropper.php, table_initializer.php, and table_maker.php. 

----------------------------------------------------------------------------------------------->


<?php 
include "table_dropper.php";
// We need to remake the connection due to the way multi_query works in table_dropper.php
$conn -> close();
$conn = make_connection();
include "table_maker.php";
include "table_initializer.php";
?>