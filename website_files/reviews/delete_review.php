<?php
include "../res/head.php";

$review_id = $_POST['review_id'];
$password = $_POST['password'];

// Query database for review data
$review_query = $conn->query("SELECT * FROM Reviews WHERE Review_ID = $review_id");
$review_data = $review_query->fetch_assoc();

// Query database for user data
$user_query = $conn->query("SELECT * FROM Users WHERE User_ID = " . $review_data['User_ID']);
$user_data = $user_query->fetch_assoc();

// Check if password matches user's password
if ($password === $user_data['Password']) {
    // Delete review from database
    $delete_query = $conn->query("DELETE FROM Reviews WHERE Review_ID = $review_id");
    echo "Review deleted.";
} else {
    echo "Incorrect password.";
}
?>
