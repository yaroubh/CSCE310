<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file handles the functionality of deleting an account from the database from the users' profile page and
redirecting them back to the login page.

----------------------------------------------------------------------------------------------->

<?php
error_reporting(E_ALL);
include "../res/head_no_nav.php";
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'test';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//Get user ID from Session
$user_id = $_SESSION['id'];

// Construct the SQL query to delete the user
$sql = "DELETE FROM users WHERE user_id = '$user_id'";

// Execute the query and check if it was successful
if (mysqli_query($con, $sql)) {
  header('Location: login.php');
} else {
  echo 'Error deleting user: ' . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>