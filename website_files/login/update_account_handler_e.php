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
$_SESSION['name'] = $_POST['username'];

// SELECT Users.Username, Users.Password, Users.Email, users.FName, Users.LName, Users.Phone_No, Employees.Employee_JobType, Employees.Hotel_ID FROM Users Inner Join Employees ON Users.user_ID = Employees.user_ID WHERE Users.user_id = ?


// Update user's account details in the database
if (!empty($_POST['new_password'])) {
    $password = $_POST['new_password'];
    // $sql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', phone_no='$phone', email='$email', password='$password' WHERE user_id=$user_id";
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

} else {

    // $sql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', phone_no='$phone', email='$email' WHERE user_id=$user_id";
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

    if (mysqli_query($conn, $sql)) {
        // echo "User account updated successfully";
        header('Location: profile.php');
    } else {
        echo "Error updating user account: " . $conn->error;
    }
?>