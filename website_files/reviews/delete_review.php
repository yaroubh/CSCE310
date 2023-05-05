<head>
        <title>Delete Review</title>
        <link rel="stylesheet" href="style.css">
    </head>
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
    echo "<p class='success'>Review deleted.</p>";
    header("refresh:1.5;url=hotel_reviews.php");
    exit;
} else {
    echo "<p class='error'>Incorrect password.</p>";
    header("refresh:1.5;url=hotel_reviews.php");
    exit;
}
?>
