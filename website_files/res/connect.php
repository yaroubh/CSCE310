<?php
# set credentials
 $servername='localhost';
 $username='root';
 $password='';
 $dbname = "test";
 # make connection
 $conn = new mysqli($servername,$username,$password,"$dbname");
   if(!$conn){
       die('Could not Connect MySql Server:' . $conn -> connect_error);
     } else {
      # print("success!");
     }
?>