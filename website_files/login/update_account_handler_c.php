<?php
error_reporting(E_ALL);
include "../res/head_no_nav.php";

//updating values for the table
$username = $_POST['username'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone_no'];
$email = $_POST['email'];

//Get user ID from Session
$user_id = $_SESSION['id'];

// Update user's account details in the database
if (!empty($_POST['new_password'])) {
    $password = $_POST['new_password'];
    $sql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', phone_no='$phone', email='$email', password='$password' WHERE user_id=$user_id";
} else {
    $sql = "UPDATE users SET username='$username', fname='$fname', lname='$lname', phone_no='$phone', email='$email' WHERE user_id=$user_id";
}

    if (mysqli_query($conn, $sql)) {
        // echo "User account updated successfully";
        header('Location: profile.php');
    } else {
        echo "Error updating user account: " . $conn->error;
    }
?>