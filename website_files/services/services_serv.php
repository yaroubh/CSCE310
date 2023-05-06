<!---------------------------------------------------------------------------------------------- 
Author of code: Krish Chhabra

Krish was responsible for coding this entire file.

This file contains <>.
----------------------------------------------------------------------------------------------->
<?php
include "../res/head.php";
?>

<!-- Display Services Assigned to Service Worker -->
<p>My Assigned Services:</p>
<?php
$q = "SELECT * FROM Service_View WHERE Emp_ID = " . $_SESSION["id"] . " ORDER BY Service_Date ASC";
$data = $conn->query($q);
if ($data->num_rows > 0) {
    while ($row = $data->fetch_assoc()) {
        echo "Service ID: " . $row["Service_ID"] . ", ";
        echo "Hotel Name: " . $row["Hotel_Name"] . ", ";
        echo "Room Number: " . $row["Room_Num"] . ", ";
        echo "Service Date: " . $row["Service_Date"] . ", ";
        echo "Service Type: " . $row["Service_Type"];
        
        echo "<br></br>";
    }
    
} else {
    echo "<p>No Services Currently</p>";
}
?>

<!-- Display All Services Assigned to Service Worker -->
<p>All Services for My Hotel:</p>
<?php
$q = "SELECT * FROM Service_View WHERE Service_View.Hotel_ID IN (SELECT Hotel_ID FROM Employees WHERE Employees.User_ID = " . $_SESSION["id"] . ") ORDER BY Service_Date ASC";
$data = $conn->query($q);
if ($data->num_rows > 0) {
    while ($row = $data->fetch_assoc()) {
        echo "Service ID: " . $row["Service_ID"] . ", ";
        echo "Hotel Name: " . $row["Hotel_Name"] . ", ";
        echo "Room Number: " . $row["Room_Num"] . ", ";
        echo "Service Date: " . $row["Service_Date"] . ", ";
        echo "Service Type: " . $row["Service_Type"] . ", ";
        if ($row["Emp_ID"] === null) {
            echo "Assigned Employee ID: None";
        }
        else {
            echo "Assigned Employee ID: " . $row["Emp_ID"];
        }
        
        echo "<br></br>";
    }
    
} else {
    echo "<p>No Services Currently</p>";
}
?>

<!-- Allow Service Worker to Delete a Service -->
<p>Delete Service:</p>
<form method='post' action='delete_service.php'>
    <label for='service_id'>Enter ID of service you wish to delete:</label>
    <input type='text' name='service_id'>
    <button type='submit'>Delete</button>
</form>

<!-- Allow Service Worker to Update Assignment of a Service -->
<p>Update Service:</p>
<form method='post' action='update_service_serv.php'>
    <label for='service_id'>Enter ID of service you wish to update:</label>
    <input type='text' name='service_id'>
    <label for='emp_id'>Enter the updated employee assignment:</label>
    <input type='text' name='emp_id'>
    <button type='submit'>Update</button>
</form>