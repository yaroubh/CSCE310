<!---------------------------------------------------------------------------------------------- 
Author of code: Jacob Enerio


This file creates a function to the MySQL database and initializes the $conn variable with that connection.
It is used in the table_dropper.php, table_initializer.php, and table_maker.php files, which do not need all the
extra information in head.php.

----------------------------------------------------------------------------------------------->

<?php

/**
 * Makes a connection to the database;
 *
 * @return mysqli Connection to the database
 */
 function make_connection() {
    // set credentials
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "test";
    // make connection
    $conn = new mysqli($servername,$username,$password,"$dbname");
    return $conn;
 }

 $conn = make_connection();
   if(!$conn){
       die('Could not Connect MySql Server:' . $conn -> connect_error);
     } else {
      // print("success!");
     }
?>