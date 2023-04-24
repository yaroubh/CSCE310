<?php include "../res/head_no_nav.php"?>
<!DOCTYPE html>
<html>
	<head>
        <link href="register.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
		<div class="register">
			<h1>Customer Registration</h1>
			<form action="registerC.php" method="post" autocomplete="off">
                <label for="firstname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="firstname" placeholder="First Name" id="firstname" required>
                <label for="lastname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="lastname" placeholder="Last Name" id="lastname" required>
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
                <label for="phone">
					<i class="fas fa-phone"></i>
				</label>
				<input type="phone" name="phone" placeholder="Phone Number" id="phone" required>
				<input type="submit" value="Register">
			</form>
            <form action="<?php echo $backup . "login/login.php"?>" method="POST">
                <button >Back to Log In</button>
            </form>
		</div>
	</body>
</html>