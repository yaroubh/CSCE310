<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file contains the frame and content of the registration page for employee registration. It
creates the form that takes in the user's respective inputs and when the submit button is pressed,
the form and the entered info is sent to registerE.php. This also creates a button for the user to
cancle the registration and go back to the login page. The difference between this and registerCustomer.php
is the type of inputs required on the form as an employee, such as hotelID and the role of the employee.
----------------------------------------------------------------------------------------------->

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
			<h1>Employee Registration</h1>
			<form action="registerE.php" method="post" autocomplete="off">
                <label for="firstname">
					<i class="fas fa-user"></i>
				</label>
				<!-- Takes in first name input -->
				<input type="text" name="firstname" placeholder="First Name" id="firstname" required>

                <label for="lastname">
					<i class="fas fa-user"></i>
				</label>
				<!-- Takes in last name input -->
				<input type="text" name="lastname" placeholder="Last Name" id="lastname" required>

				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<!-- Takes in username input -->
				<input type="text" name="username" placeholder="Username" id="username" required>

				<label for="hotelid">
                    <i class="fas fa-hotel"></i>
                </label>
				<!-- Takes in hotel Id input -->
                <input type="text" name="hotelid" placeholder="Hotel ID" id="hotelid" required>

                <label for="employeeType">
					<i class="fas fa-bell"></i>
				</label>
				<!-- Takes in the role of the user as an employee -->
				<input type="text" name="employeeType" placeholder="Role (administrator, receiptionist, etc.)" id="employeeType" required>

				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<!-- Takes password input -->
				<input type="password" name="password" placeholder="Password" id="password" required>

				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<!-- Takes email input -->
				<input type="email" name="email" placeholder="Email" id="email" required>

                <label for="phone">
					<i class="fas fa-phone"></i>
				</label>
				<!-- Takes phone number input -->
				<input type="phone" name="phone" placeholder="Phone Number" id="phone" required>
				<!-- submission button -->
				<input type="submit" value="Register">
			</form>
			<!-- Button to go back to login page and cancle registration -->
            <form action="<?php echo $backup . "login/login.php"?>" method="POST">
                <button>Back to Log In</button>
            </form>
		</div>
	</body>
</html>