<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file contains the functionality of updating an employee's account. The code takes in the inputs
from the form submitted in update_account_emp.php and updates the inputs' respective attributes in
the users and employees table. Since updating your password is optional, this code checks to see if a new password
was provided and updates accordingly, otherwise leaves it as be and modifies the rest of the account
info.
----------------------------------------------------------------------------------------------->

<?php
error_reporting(E_ALL);
include "../res/head_no_nav.php";

//updating values for the table
$username = $_POST['username'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone_no'];
$email = $_POST['email'];
$jobtype = $_POST['jobtype'];
$hotel = $_POST['hotelid'];

//Get user ID from Session
$user_id = $_SESSION['id'];

// Update user's account details in the database
// If the user enters a new password, update everything else and the password
if (!empty($_POST['new_password'])) {
    $password = $_POST['new_password'];
    $sql = "UPDATE users u 
    JOIN employees e ON (u.user_id = e.user_id) 
    SET u.username = '$username', 
        u.password = '$password', 
        u.email = '$email', 
        u.fname = '$fname', 
        u.lname = '$lname',
        u.phone_no = '$phone',
        e.employee_jobtype = '$jobtype',
        e.hotel_id = '$hotel'
    WHERE u.user_id = '$user_id'";

} 
// If the user does not enter a new password, then update everything else that was modified
else {

    $sql = "UPDATE users u 
    JOIN employees e ON (u.user_id = e.user_id) 
    SET u.username = '$username',  
        u.email = '$email', 
        u.fname = '$fname', 
        u.lname = '$lname',
        u.phone_no = '$phone',
        e.employee_jobtype = '$jobtype',
        e.hotel_id = '$hotel'
    WHERE u.user_id = '$user_id'";
}
    // Submit the SQL request and take back to the profile page to display the newly updated content.
    if (mysqli_query($conn, $sql)) {
        header('Location: profile.php');
    } 
    // Error handling if unable to submit SQL request
    else {
        echo "Error updating user account: " . $conn->error;
    }
?>