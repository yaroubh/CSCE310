<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file creates the profile page by connecting to the database, selecting the users table, and 
gathering the relevant data specific to the current user logged in and displays it on a text box 
that is formatted in HTML within this file. 
----------------------------------------------------------------------------------------------->

<?php
// error handling
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../res/head.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}

// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $conn->prepare('SELECT username, password, email, fname, lname, phone_no, user_type FROM users WHERE user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($username, $password, $email, $fname, $lname, $phone_no, $user_type);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title of page -->
		<title>Profile Page</title>
		<link href="home.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<!-- Displays the relevant content of the current user's account info -->
				<p>Your account details are below:</p>
				<table>
					<!-- This pulls from the current user, and will change depending on who the current user is -->
                    <tr>
						<td>First Name:</td>
						<td><?=$fname?></td>
					</tr>
                    <tr>
						<td>Last Name:</td>
						<td><?=$lname?></td>
					</tr>
                    <tr>
						<td>Username:</td>
						<td><?=$username?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
                    <tr>
						<td>Phone Number:</td>
						<td><?=$phone_no?></td>
					</tr>
					<tr>
						<td>User Type:</td>
						<td><?=$user_type?></td>
					</tr>
				</table>
			</div>
				<!-- Checks to see if the user is a customer or an employee -->
				<?php
					// if customer, pressing the edit account button brings up the relevant
					// content to be edited by the customer through redirection to a customer
					// updating file.
					if ($user_type === 'Customer'){
						echo '<form action="update_account_cust.php" method="POST">';
                		echo '<button>Edit Account</button>';
						echo '</form>';
					} 
					// if customer, pressing the edit account button brings up the relevant
					// content to be edited by the employee through redirection to a employee
					// updating file. this differs by allowing the editing of hotel id and job
					// role for example.
					elseif ($user_type === 'Employee'){
						echo '<form action="update_account_emp.php" method="POST">';
                		echo '<button>Edit Account</button>';
						echo '</form>';
					}
				?>
            </form>
		</div>
	</body>
</html>


