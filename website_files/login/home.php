<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file handles the frame and contents of the landing home page that a user is first redirected to when
successfully logging in. This page displays a greeting with current user's username, and if they are an employee, the employee's
role.
----------------------------------------------------------------------------------------------->

<?php

$user_type = $_SESSION["User_Type"];

include "../res/head.php";
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- Title of the page -->
		<title>Home Page</title>
		<link href="home.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body class="loggedin">
		<div class="content">
			<!-- The greeting on the home page after logging in -->
			<h2>Home Page</h2>
			<p>Welcome back, <?=$_SESSION['name']?>!</p>
			<p> You are a <?php echo $_SESSION['user_type'];?></p>
			<!-- Checks to see if the user is an employee, and if so displays the employee's role under the other two text boxes -->
			<?php if ($_SESSION['user_type'] === "Employee") { ?>
                <p> Your current role is a <?php echo $_SESSION['employee_jobtype'];?></p>
            <?php } ?>
		</div>
	</body>
</html>