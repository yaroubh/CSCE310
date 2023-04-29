<?php

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
		<title>Profile Page</title>
		<link href="home.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
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
				<?php

					if ($user_type === 'Customer'){
						echo '<form action="update_account_cust.php" method="POST">';
                		echo '<button>Edit Account</button>';
						echo '</form>';
					}
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


