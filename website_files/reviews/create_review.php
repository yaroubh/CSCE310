<?php include "../res/head.php"; 
/**
 * Author: Uchenna Akahara
 * Func. Set 4
 * This code is for editing a hotel review in a web application. 
 * It retrieves the review details from the database based on the review ID passed through a 
 * GET request, and displays a form to edit the review's description, rating, and requires the user 
 * to input their password for authentication. 
 * If the password is correct, the review is updated in the database and the user 
 * is redirected back to the hotel_reviews.php page with a success message.
 */
?>
<link rel="stylesheet" href="style.css">
<div id = "review-button">
    <a href="hotel_reviews.php" class="btn btn-primary">Back to Review</a>
</div>

<div>
  <h1 class="title">Create a Review</h1>

  <!-- Create basic review form -->

  <form method="post" action="create_review.php">
    <div class="form-group">
      <label for="username">Username:</label>
      <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
    </div>

    <div class="form-group">
      <label for="hotel">Hotel Name:</label>
      <input type="text" class="form-control" id="hotel" name="hotel" placeholder="Enter the hotel name">
    </div>

    <div class="form-group">
      <label for="rating">Rating:</label>
      <select class="form-control" id="rating" name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
    </div>

    <div class="form-group">
        
       <label for="date_time">Date and Time:</label>
       <input type="datetime-local" class="form-control" id="date_time" name="date_time">

       <label for="description">Review:</label>
       <textarea class="form-control" id="description" name="description" rows="5"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>


  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve input values
        $username = strtolower(trim($_POST['username']));
        $hotel = strtolower(trim($_POST['hotel']));
        $rating = intval($_POST['rating']);
        $description = $_POST['description'];
        $date_time = date('Y-m-d H:i:s', strtotime($_POST['date_time']));
        
        // Query database to check if username and hotel exist
        $username_result = $conn->query("SELECT * FROM Users WHERE lower(trim(Username)) = '$username'");
        $hotel_result = $conn->query("SELECT * FROM Hotel WHERE lower(trim(Hotel_Name)) = '$hotel'");

        if ($username_result->num_rows == 0) {
          echo "<p class='error'>Error: Username does not exist</p>";
          
        } 
        elseif ($hotel_result->num_rows == 0) {
          echo "<p class='error'>Error: Hotel name does not exist</p>";
        } 

        else {
          // Retrieve the user and hotel IDs
          $user_id = $username_result->fetch_assoc()["User_ID"];
          $hotel_id = $hotel_result->fetch_assoc()["Hotel_ID"];

          // Insert review into database
          $q = "INSERT INTO Reviews (Hotel_ID, User_ID, Rating, Description, Review_Date) VALUES ($hotel_id, $user_id, $rating, '$description', '$date_time')";
          if ($conn->query($q) === TRUE) {
            echo "<p class='success'>Review successfully created</p>";
            header("refresh:1.5;url=hotel_reviews.php");
            exit;
          } else {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
            header("refresh:1.5");
            exit;
          }
        }
      }
  ?>

</div>
