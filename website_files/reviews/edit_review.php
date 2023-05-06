<?php /**
 * Author: Uchenna Akahara
 * Func. Set 4
 * Note: Jacob Enerio fixed a bug with the post request. It was fixed by setting the if ($_SERVER['REQUEST_METHOD'] === 'POST') 
 * block to the beggining of the php file
 * 
 * This script allows a user to edit an existing review. It includes a form with 
 * fields for the new review description, rating, and the user's password for authentication. 
 * The script queries the database for the review data, and if the user's password is correct, updates the review 
 * description and rating in the database. If the password is incorrect, an error message is displayed. 
 * Finally, the script redirects the user back to the hotel_reviews.php page after a short delay.
 * 
 */

 // Originally coded by Uchenna, but moved to the beginning by Jacob
 include "../res/connect.php";
 $review_id = $_GET['id'];
 $q = "SELECT * FROM Reviews WHERE Review_ID = $review_id";
 $data = $conn->query($q);
 $row = $data->fetch_assoc();

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $review_id = $_POST['review_id'];
  $description = $_POST['description'];
  $rating = $_POST['rating'];
  $password = $_POST['password'];

  // verify password
  $q = "SELECT * FROM Users WHERE User_ID = $row[User_ID] AND Password = '$password'";
  $data = $conn->query($q);
  if ($data->num_rows > 0) {
    // update review description and rating
    $q = "UPDATE Reviews SET Description = '$description', Rating = '$rating' WHERE Review_ID = $review_id";
    $conn->query($q);
    echo "<p class='success'>Review updated successfully!</p>";
    // redirect back to hotel_reviews.php
    header("refresh:1.5;url=hotel_reviews.php");
    exit;
  } else {
    echo "<p class='error'>Incorrect password.</p>";
  }
  
}
// End of code moved to the top by Jacob


// Rest of code is by Uchenna
include "../res/head.php"; ?>
<link rel="stylesheet" href="style.css">
<div>
  <h1 class="title">Edit Review</h1>

  <form method='post' action='edit_review.php?id=<?php echo $row["Review_ID"]; ?>'>
    <input type='hidden' name='review_id' value='<?php echo $row["Review_ID"]; ?>'>
    <label for='description'>New Review Description:</label>
    <textarea name='description'><?php echo $row["Description"]; ?></textarea>
    <br>
    <label for='rating'>New Rating:</label>
    <input type='number' name='rating' min='1' max='5' value='<?php echo $row["Rating"]; ?>'>
    <br>
    <label for='password'>Enter your password:</label>
    <input type='password' name='password'>
    <br>
    <button type='submit'>Update Review</button>
    
  </form>

</div>
