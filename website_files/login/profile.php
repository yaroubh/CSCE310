<?php
include "../res/head.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $conn->prepare('SELECT password, email, fname, lname, phone_no FROM users WHERE user_id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $fname, $lname, $phone_no);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
		<link href="home.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<!-- <div class="account-form">
			<h2>Edit Account Details</h2>
			<form method="post" action="update_account.php">
				<input type="hidden" name="id" value="<?php echo $fname; ?>" />
				<label for="firstname">First Name:</label>
				<input type="text" name="name" value="<?php echo $lname; ?>" required />
				<label for="lastname">Last Name:</label>
				<input type="email" name="email" value="<?php echo $email; ?>" required />
				<label for="email">Email:</label>
				<input type="password" name="password" required />
				<button type="submit" name="update">Update Account</button>
			</form>
		</div>

		<div class="account-form">
			<h2>Delete Account</h2>
			<form method="post" action="delete_account.php">
				<input type="hidden" name="id" value="<?php echo $user_id; ?>" />
				<p>Are you sure you want to delete your account?</p>
				<button type="submit" name="delete">Delete Account</button>
			</form>
		</div> -->
	
		<div class="content">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
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
						<td><?=$_SESSION['name']?></td>
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
				</table>
			</div>
			<form action="update_account_cust.php" method="POST">
                <button>Edit Account</button>
            </form>
		</div>
	</body>
</html>


