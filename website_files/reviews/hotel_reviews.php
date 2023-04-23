<?php include "../res/head.php"; ?>
<link rel="stylesheet" href="style.css">
<div>
  <h1 class="title">Hotel Reviews</h1>
  
    <?php
    $q = "SELECT * FROM Reviews ORDER BY Review_ID ASC";
    $data = $conn->query($q);
    
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<div class='review-header'>";
            $u_name_query = $conn->query("SELECT * FROM Users WHERE User_ID = $row[User_ID]");
            $u_name = $u_name_query->fetch_assoc();
            echo "<div class='user-id'>User: " . $u_name["Username"] . "</div>";
            $h_name_query = $conn->query("SELECT * FROM Hotel WHERE Hotel_ID = $row[Hotel_ID]");
            $h_name = $h_name_query->fetch_assoc();
            echo "<div class='hotel-info'>" . $h_name["Hotel_Name"] . " | " . $row["Review_Date"] . "</div>";
            echo "</div>";
            echo "<div class='review-description'>" . $row["Description"] . "</div>";
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
