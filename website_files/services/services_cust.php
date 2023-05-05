<!---------------------------------------------------------------------------------------------- 
Author of code: Krish Chhabra

Krish was responsible for coding this entire file.

This file contains <>.
----------------------------------------------------------------------------------------------->
<?php
include "../res/head.php";
?>

<!-- Display Services of Customer's Active Bookings -->
<p>My Services:</p>
<?php
$q = "SELECT * FROM Service_View WHERE Cust_ID = " . $_SESSION["id"] . " ORDER BY Service_Date ASC";
$data = $conn->query($q);
if ($data->num_rows > 0) {
    while ($row = $data->fetch_assoc()) {
        echo "Service ID: " . $row["Service_ID"] . ", ";
        echo "Hotel Name: " . $row["Hotel_Name"] . ", ";
        echo "Room Number: " . $row["Room_Num"] . ", ";
        echo "Service Date: " . $row["Service_Date"] . ", ";
        echo "Service Type: " . $row["Service_Type"] . ", ";
        echo "Price: " . $row["Price"] . ", ";
        echo "Employee Name: " . $row["Emp_FName"] . " " . $row["Emp_LName"] . ", ";
        echo "Employee Email: " . $row["Emp_Email"] . ", ";
        echo "Booking Start: " . $row["Start_Date"] . ", ";
        echo "Booking End: " . $row["End_Date"];

        echo "<br></br>";
    }
    
} else {
    echo "<p>No Services Currently</p>";
}
?>

<!-- Allow Customer to Delete a Service -->
<p>Delete Service:</p>
<form method='post' action='delete_service.php'>
    <label for='service_id'>Enter ID of service you wish to delete:</label>
    <input type='text' name='service_id'>
    <button type='submit'>Delete</button>
</form>

<!-- Allow Customer to Update Date of a Service -->
<p>Update Service:</p>
<form method='post' action='update_service_cust.php'>
    <label for='service_id'>Enter ID of service you wish to update:</label>
    <input type='text' name='service_id'>
    <label for='service_date'>Enter the updated service date:</label>
    <input type='text' name='service_date'>
    <button type='submit'>Update</button>
</form>