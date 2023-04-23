<?php include "../res/head.php"?>
<!DOCTYPE html>
<html>
	<head>
        <link href="login.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" value="Login">
			</form>
            <form action="<?php echo $backup . "login/registerCustomer.php"?>" method="POST">
                <button>Register as Customer</button>
            </form>
			<form action="<?php echo $backup . "login/registerEmployee.php"?>" method="POST">
                <button>Register as Employee</button>
            </form>
		</div>
	</body>
</html>