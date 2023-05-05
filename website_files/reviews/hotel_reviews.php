<?php include "../res/head.php"; ?>
<link rel="stylesheet" href="style.css">
<div>
  <h1 class="title">Hotel Reviews</h1>
  
    <?php
    $q = "SELECT * FROM Reviews ORDER BY Review_Date ASC";
    $data = $conn->query($q);
    // iterate through reviews in db and print to screen. If there are no reviews, print 0.
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "<div class='review'>";
            // create review button
            echo "<a href='edit_review.php?id=" . $row['Review_ID'] . "' class='edit-button'>Edit</a>";
            echo "<div class='review-header'>";
            
            $u_name_query = $conn->query("SELECT * FROM Users WHERE User_ID = $row[User_ID]");
            $u_name = $u_name_query->fetch_assoc();
            echo "<div class='user-id'>User: " . $u_name["Username"] . "</div>";
            $h_data_query = $conn->query("SELECT * FROM Hotel WHERE Hotel_ID = $row[Hotel_ID]");
            $h_data = $h_data_query->fetch_assoc();
            echo "<div class='hotel-info'>" . $h_data["Hotel_Name"] . " | Rating: " . $row["Rating"] . " | ". $row["Review_Date"] . "</div>";
            echo "</div>";
            echo "<div class='review-description'>" . $row["Description"] . "</div>";
            echo "</div>";

            // add delete button for each review

            echo "<form method='post' action='delete_review.php'>";
            echo "<input type='hidden' name='review_id' value='" . $row["Review_ID"] . "'>";
            echo "<label for='password'>Enter your password to delete this review:</label>";
            echo "<input type='password' name='password'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";
            
            echo "</div>";
        }
    } else {
        echo "<tr><td colspan='2'>0 results</td></tr>";
    }
    ?>
   
  <div id = "review-button">
    <a href="create_review.php" class="btn btn-primary">Create Review</a>
  </div>
  

  </div>
</div>
