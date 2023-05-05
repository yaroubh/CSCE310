<?php include "../res/head.php"; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Hotel Reviews: Admin</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php

        // Handle delete review request
        if (isset($_POST["delete_review"])) {
            // echo $_POST;
            $review_id = $_POST["review_id"];
            // echo "Review ID: " . $review_id;
            $sql = "DELETE FROM Reviews WHERE Review_ID = $review_id";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Review deleted successfully</p>";
            } else {
                echo "<p class='error'>Error deleting review: </p>";
                echo $conn->error;
            }
        }

        // echo $sql;

        // Get reviews from Review_View
        $sql = "SELECT * FROM Review_View ORDER BY Review_Date ASC";
        $result = $conn->query($sql);

        // Display reviews in a list
        if ($result->num_rows > 0) {
            echo "<ul class='review_list'>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<div class='review'>";
                echo "<div class='review-header'>";
                echo "<div class='hotel-info'>";
                $sql = "SELECT Hotel_Name FROM Hotel WHERE Hotel_ID = '$row[Hotel_ID]'";
                $r = $conn->query($sql);
                $name = $r->fetch_assoc();
                echo "<p>Hotel_Name (Hotel_ID): "  . $name["Hotel_Name"] . " (" . $row["Hotel_ID"] . ")</p>";
                echo "<p>Rating: " .$row["Rating"] . " | ". $row["Review_Date"] . "</p></div>";
                echo "</div>";
                echo "<div class='review-description'>" . $row["Description"] . "</div>";
                // Add delete button for each review
                echo "<form method='post'>";
                echo "<input type='hidden' name='review_id' value='" . $row["Review_ID"] . "'>";
                echo "<button type='submit' name='delete_review'>Delete</button>";
                echo "</form>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='error'>No reviews found.</p>";
        }
        ?>
    </body>
</html>
