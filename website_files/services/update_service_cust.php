<!---------------------------------------------------------------------------------------------- 
Author of code: Krish Chhabra

Krish was responsible for coding this entire file.

This file contains the code that allows a customer to update the date of a service associated
with their active bookings.
----------------------------------------------------------------------------------------------->
<?php
include "../res/head.php";

// get service id and requested date from form
$service_id = $_POST['service_id'];
$new_date = $_POST['service_date'];

// check validity of service id
$user_check_query = "SELECT Service_ID FROM Service_View
                     WHERE Service_ID = " . $service_id . " AND CUST_ID = " . $_SESSION["id"] . " AND
                     (Start_Date <= '" . $new_date . "' AND End_Date >= '" . $new_date . "')";

$check_result = null;
try {
    $check_result = $conn->query($user_check_query)->fetch_assoc();
} catch (Exception $ex) {
    // echo $ex;
}

// service id doesn't exist
if ($check_result === null) {
    echo "Invalid Request. Service ID is invalid, this is not your service, or the update date is outside of the associated booking.";
}

// service id exists and is allowed to be updated by this user with the given date
else {
    $conn->query("UPDATE Hotel_Service SET Service_Date = '" . $new_date . "' WHERE Service_ID = " . $service_id);
    echo "Date for service with ID " . $service_id . " updated to " . $new_date;
}

// return to services page
echo "<br></br>";
echo "<a href = 'services_cust.php'>Back to Services Page</a>";
?>