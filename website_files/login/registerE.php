<?php
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

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['hotelid'], $_POST['employeeType'], $_POST['password'], $_POST['email'],  $_POST['phone'])) {
    // Could not get the data that should have been sent.
    exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['username']) || empty($_POST['hotelid']) || empty($_POST['employeeType']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['phone'])) {
    // One or more values are empty.
    exit('Please complete the registration form');
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT user_id, password FROM users WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'Username exists, please choose another!';
        echo '<p><a href="registerEmployee.php">Go to employee registration page</a></p>';
    } else {
        // Insert new account
        // Username doesn't exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO users (fname, lname, username, password, email, phone_no, user_type) VALUES (?, ?, ?, ?, ?, ?, "Employee")')) {
            # The first parameter indicates the types of variables for each column
            # the first column, fname should be a string, so it's "s"
            # The last custom column, phone_no, should be an integer, so it's "i"
            # There are six custom columns, so there are 6 letters, one for each column

            $stmt->bind_param('sssssi', $_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['phone']);
            $stmt->execute(); //causing problems
            $stmt->close();

            // We now need to get the user id
            $stmt = $con->prepare('SELECT user_id FROM users WHERE username = ?');
            // In this case we want to get the user id and bind the result to it.
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute();
            $stmt->bind_result($user_id);
            $stmt->fetch();
            $stmt->close();

            # Insert into employees table
            if ($stmt = $con->prepare('INSERT INTO employees (user_id, hotel_id, employee_jobtype) VALUES (?, ?, ?)')) {
                $stmt->bind_param('sis', $user_id, $_POST['hotelid'], $_POST['employeeType']);
                
                $stmt -> execute();
                # We also need to make sure to add a new customer to the customers table
                echo '<p>You have successfully registered! You can now login</p>';
                # Echo link to login page
                echo '<p><a href="login.php">Go to login page</a></p>';
            } else {
                echo 'Could not prepare statement!';
            }
        } else {
            // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
            echo 'Could not prepare statement!';
            }
    }
    $stmt->close();
} else {
    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all 3 fields.
    echo 'Could not prepare statement!';
}
$con->close();
?>

