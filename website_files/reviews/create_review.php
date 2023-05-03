                                    <?php include "../res/head.php"; ?>
<link rel="stylesheet" href="style.css">
<div id = "review-button">
    <a href="hotel_reviews.php" class="btn btn-primary">Back to Review</a>
</div>

<div>
  <h1 class="title">Create a Review</h1>

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

        // Create indexes on the relevant columns

        // $conn->query("CREATE INDEX idx_users_username ON Users (Username)");
        // $conn->query("CREATE INDEX idx_hotel_hotel_name ON Hotel (Hotel_Name)");

      
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
          } else {
            echo "<p class='error'>Error: " . $conn->error . "</p>";
          }
        }
      }
  ?>

</div>
