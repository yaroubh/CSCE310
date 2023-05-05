<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file contains the connection to a table the inner joins the users table and employees table, and 
contains the frame and content of the account update page. 
This page is where an employee edits their account information or deletes their account. The code provides 
textboxes with current values respective to the input fields to remind the user what values are currently 
set to the shown attributes. The code also provides a button labeled "Delete Account" which calls 
delete_account.php and has the account and all of its appropriate data removed from the database.
----------------------------------------------------------------------------------------------->

<?php
include "../res/head.php";

// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'test';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// // We don't have the password or email info stored in sessions, so instead, we can get the results from the database.

//USE EMP_VIEW INSTEAD

// $stmt = $conn->prepare('SELECT username, password, email, fname, lname, phone_no FROM users WHERE user_id = ?');
$stmt =$conn->prepare('SELECT Users.Username, Users.Password, Users.Email, users.FName, Users.LName, Users.Phone_No, Employees.Employee_JobType, Employees.Hotel_ID FROM Users Inner Join Employees ON Users.user_ID = Employees.user_ID WHERE Users.user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
// $stmt->bind_result($username, $password, $email, $fname, $lname, $phone_no);
$stmt->bind_result($username, $password, $email, $fname, $lname, $phone_no, $employee_jobtype, $hotel_id);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html>
	<head>
        <script>
        // Prompts warning to user asking if they are sure they want to delete their account and that pressing the button was not an accident.
        function showWarning() {
            if (confirm("Are you sure you want to proceed?")) {
                // Perform the action
                alert("Account deleted successfully.")
            } else{
                return false;
            }
        }
        </script>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="test.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<div class="account-form">
			<h2>Edit Account Details</h2>

			<form method="post" action="update_account_handler_e.php">
                <input type="hidden" name="id" value="<?php echo $user_id; ?>" />

                <!-- Shows field for username -->
                <label for="name">Username:</label>
                <input type="text" name="username" placeholder="<?php echo $username; ?>" value="<?php echo $username; ?>" required />

                <!-- Shows field for first name -->
                <label for="name">First Name:</label>
                <input type="text" name="fname" placeholder="<?php echo $fname; ?>" value="<?php echo $fname; ?>" required />

                <!-- Shows field for last name -->
                <label for="name">Last Name:</label>
                <input type="text" name="lname" placeholder="<?php echo $lname; ?>" value="<?php echo $lname; ?>" required />

                <!-- Shows field for hotel id-->
                <label for="name">Hotel ID:</label>
                <input type="text" name="hotelid" placeholder="<?php echo $hotel_id; ?>" value="<?php echo $hotel_id; ?>" required />

                <!-- Shows field for employee role -->
                <label for="name">Role:</label>
                <input type="text" name="jobtype" placeholder="<?php echo $employee_jobtype; ?>" value="<?php echo $employee_jobtype; ?>" required />

                <!-- Shows field for phone number -->
                <label for="email">Phone Number:</label>
                <input type="text" name="phone_no" placeholder="<?php echo $phone_no?>" value="<?php echo $phone_no; ?>" required />

                <!-- Shows field for email -->
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="<?php echo $email?>" value="<?php echo $email; ?>" required />

                <!-- Shows field for password -->
                <label for="password">Password:</label>
                <input type="password" name="new_password" placeholder="If desired, enter new password." />

                <!-- Creates a button to submit the form and update the account if any modifications were made -->
                <button type="submit" name="update">Update Account</button>
			</form>

            <!-- Creates a form and button for deleting the users account. Calls delete_account.php -->
            <form method="post" action="delete_account.php">
				<input type="hidden" name="id" value="<?php echo $user_id; ?>" />
                <!-- Calls and displays warning defined at the top of the code when the button is clicked. -->
				<button onclick="return showWarning()" type="submit" name="delete">
                    Delete Account
                </button>
			</form>
            
		</div>
    </body>
</html>