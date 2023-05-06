<!---------------------------------------------------------------------------------------------- 
Author of code: Krish Chhabra

Krish was responsible for coding this entire file.

This file contains the code required to delete a service from the database given a service_id.
Checks for the validity of the delete request, executing the request if valid.
----------------------------------------------------------------------------------------------->
<?php
include "../res/head.php";

// get service id from form
$service_id = $_POST['service_id'];

// check validity of service id
$user_check_query = "SELECT Cust_ID, Emp_ID, Hotel_ID FROM Service_View WHERE Service_ID = " . $service_id;
$check_result = $conn->query($user_check_query)->fetch_assoc();

// service id doesn't exist
if ($check_result === null) {
    echo "Invalid Service ID";
}

// service id exists and is allowed to be deleted by this user
// must belong to the user as a customer, be assigned to the service worker, or user must be an admin
else if ($_SESSION["id"] == $check_result["Cust_ID"] || $_SESSION["id"] == $check_result["Emp_ID"] || $_SESSION["employee_jobtype"] === "Administrator") {
    // delete from both service and assignment tables
    $conn->query("DELETE FROM Hotel_Service WHERE Service_ID = " . $service_id);
    $conn->query("DELETE FROM Service_Assignment WHERE Service_ID = " . $service_id);
    echo "Deleted service with ID " . $service_id;
}

// service id exists but user not authrized to delete
else {
    echo "You are not authorized to delete this service";
}

// return to services page
echo "<br></br>";
echo "<a href = 'services_cust.php'>Back to Services Page</a>";
?>