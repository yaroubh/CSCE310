<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'test';

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT User_ID, Password, User_Type FROM Users WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $user_type);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['user_type'] = $user_type;
            // Get the employee job type if it's an employee
            if ($user_type === "Employee") {
                $stmt -> close();
                $stmt = $con->prepare('SELECT Employee_JobType FROM Employees WHERE User_ID = ?');
                $stmt->bind_param('i', $id);
                $stmt->execute();
                // Bind the employee jobtype
                $stmt -> bind_result($employee_jobtype);
                $stmt -> fetch();
                $_SESSION['employee_jobtype'] = $employee_jobtype;

            } else {
                $_SESSION['employee_jobtype'] = "NA";
            }
            // echo 'Welcome ' . $_SESSION['name'] . '!';
            header('Location: home.php');
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
            // header('Location: login.html');
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
        // header('Location: login.html');
    }

	$stmt->close();
}
?>

