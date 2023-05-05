<?php
include "../res/head.php";

$service_id = $_POST['service_id'];

$user_check_query = "SELECT Cust_ID, Emp_ID FROM Service_View WHERE Service_ID = " . $service_id;
$check_result = $conn->query($user_check_query)->fetch_assoc();

if ($check_result === null) {
    echo "Invalid Service ID";
}
else if ($_SESSION["id"] == $check_result["Cust_ID"] || $_SESSION["id"] == $check_result["Emp_ID"] || $_SESSION["employee_jobtype"] === "Administrator") {
    $conn->query("DELETE FROM Hotel_Service WHERE Service_ID = " . $service_id);
    $conn->query("DELETE FROM Service_Assignment WHERE Service_ID = " . $service_id);
    echo "Deleted service with ID " . $service_id;
}
else {
    echo "You are not authorized to delete this service";
}


echo "<br></br>";
echo "<a href = 'services_cust.php'>Back to Services Page</a>";
?>