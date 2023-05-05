<?php include "../res/head.php"; ?>
<link rel="stylesheet" href="style.css">
<div>
  <h1 class="title">Edit Review</h1>

  <?php
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
  ?>

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
