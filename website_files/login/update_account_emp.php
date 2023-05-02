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

                <label for="name">Username:</label>
                <input type="text" name="username" placeholder="<?php echo $username; ?>" value="<?php echo $username; ?>" required />

                <label for="name">First Name:</label>
                <input type="text" name="fname" placeholder="<?php echo $fname; ?>" value="<?php echo $fname; ?>" required />

                <label for="name">Last Name:</label>
                <input type="text" name="lname" placeholder="<?php echo $lname; ?>" value="<?php echo $lname; ?>" required />

                <label for="name">Hotel ID:</label>
                <input type="text" name="hotelid" placeholder="<?php echo $hotel_id; ?>" value="<?php echo $hotel_id; ?>" required />

                <label for="name">Role:</label>
                <input type="text" name="jobtype" placeholder="<?php echo $employee_jobtype; ?>" value="<?php echo $employee_jobtype; ?>" required />

                <label for="email">Phone Number:</label>
                <input type="text" name="phone_no" placeholder="<?php echo $phone_no?>" value="<?php echo $phone_no; ?>" required />

                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="<?php echo $email?>" value="<?php echo $email; ?>" required />

                <label for="password">Password:</label>
                <input type="password" name="new_password" placeholder="If desired, enter new password." />

                <button type="submit" name="update">Update Account</button>
			</form>

            <form method="post" action="delete_account.php">
				<input type="hidden" name="id" value="<?php echo $user_id; ?>" />
				<!-- <p>Are you sure you want to delete your account?</p> -->
				<button onclick="return showWarning()" type="submit" name="delete">
                    Delete Account
                </button>
			</form>
            
		</div>
    </body>
</html>