<!---------------------------------------------------------------------------------------------- 
Author of code: Krish Chhabra

Krish was responsible for coding this entire file.

This file contains <>.
----------------------------------------------------------------------------------------------->
<?php
include "../res/head.php";

// get service id and requested assignment from form
$service_id = $_POST['service_id'];
$new_emp = $_POST['emp_id'];

// check validity of service id
$user_check_query = "SELECT Service_ID FROM Service_View
                     WHERE Service_ID = " . $service_id . " AND (Emp_ID = " . $_SESSION["id"] . " OR Emp_ID = null) AND
                     Service_View.Hotel_ID IN (SELECT Hotel_ID FROM Employees WHERE Employees.User_ID = " . $new_emp . ")";

$check_result = null;
try {
    $check_result = $conn->query($user_check_query)->fetch_assoc();
} catch (Exception $ex) {
    // echo $ex;
}

// service id doesn't exist
if ($check_result === null) {
    echo "Invalid Request. Service ID is invalid, this service is assigned someone, or new employee is in a different hotel.";
}

// service id exists and is allowed to be updated by this user with the given date
else {
    try {
        $conn->query("UPDATE Service_Assignment SET User_ID = " . $new_emp . " WHERE Service_ID = " . $service_id . " AND 
                      (User_ID = " . $_SESSION["id"] . " OR User_ID = null)");
        echo "Transferred service with ID " . $service_id . " to employee " . $new_emp;
    } catch (Exception $ex) {
        echo "New employee has already been assigned to this service";
    }
}

// return to services page
echo "<br></br>";
echo "<a href = 'services_serv.php'>Back to Services (Service Worker View) Page</a>";
?>