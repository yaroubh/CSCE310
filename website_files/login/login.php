<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file contains the frame and content of the login page. It provides the forms where the user enters in
their username and password, sends the entered credentials to be checked by authenticate.php, and holds optional buttons
for registering a new account as either an employee or customer.
----------------------------------------------------------------------------------------------->

<?php include "../res/head_no_nav.php"?>
<!DOCTYPE html>
<html>
	<head>
        <link href="login.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<!-- Title of the page -->
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<!-- The login window/box. -->
			<h1>Login</h1>
			<!-- Setting the form's action after submitting request to be sent to authenticate.php to be authenticated. -->
			<form action="authenticate.php" method="post">
				<!-- Assigning user icon to password field -->
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<!-- Takes in username as input -->
				<input type="text" name="username" placeholder="Username" id="username" required>
				
				<!-- Assigning lock icon to password field -->
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<!-- Takes in password as input -->
				<input type="password" name="password" placeholder="Password" id="password" required>
				<!-- the button to submit the login request -->
				<input type="submit" value="Login">
			</form>
			<!-- Button for registering as customer, redirecting to customer registration file -->
            <form action="<?php echo $backup . "login/registerCustomer.php"?>" method="POST">
                <button>Register as Customer</button>
            </form>
			<!-- Button for registering as employee, redirecting to employee registration file -->
			<form action="<?php echo $backup . "login/registerEmployee.php"?>" method="POST">
                <button>Register as Employee</button>
            </form>
		</div>
	</body>
</html>