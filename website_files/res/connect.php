<?php

/**
 * Makes a connection to the database;
 *
 * @return mysqli Connection to the database
 */
 function make_connection() {
    # set credentials
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "test";
    # make connection
    $conn = new mysqli($servername,$username,$password,"$dbname");
    return $conn;
 }

 $conn = make_connection();
   if(!$conn){
       die('Could not Connect MySql Server:' . $conn -> connect_error);
     } else {
      # print("success!");
     }
?>