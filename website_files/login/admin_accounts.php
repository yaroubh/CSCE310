<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein (Assisted by Jacob Enrino)

Yaroub was responsible for coding this entire file with Jacob helping me implement functions he created in other files at lines.
Jacob assisted with the function calls and the proper ways to set them up in lines 19, 22, 37, and 44.

This file contains the function of the Admin's view of profiles by displaying both the Customer and Employees table with all of their relevant profile information on one page.
It allows each table and every account in each table to be viewed, edited, and deleted.

----------------------------------------------------------------------------------------------->

<?php
error_reporting(E_ALL);
$suspend_head = true;
include "../res/head.php"; 

// Make the tables and filter objects
// Allows administrators to view users
$users_table = generate_data_editor($data_editors, $data_tables, "users-div", "b-rv-users", "Users", "SELECT User_ID, FName, LName, Phone_NO, Email, Username, Password FROM Users WHERE User_Type = 'Customer'", "Inf", ["text", "text", "text", "text", "text", "text"], []);

// Allows administrators to view employees
$emps_table = generate_data_editor($data_editors, $data_tables, "emps-div", "b-rv-emps", "Users", "SELECT Users.User_ID, Users.FName, Users.LName, Users.Phone_NO, users.Email, Users.Username, Users.Password, Employees.Hotel_ID, Employees.Employee_JobType FROM Users Inner Join Employees ON Users.user_ID = Employees.user_ID", "Inf", ["text", "text", "text", "text", "text", "text", "text", "text"], []);

// Include the query handler and table generator files
include $backup . "res/query_handler.php";
include $backup . "res/table_generator.php";

// Print all the stuff in head like navbar
echo ob_get_clean();

?>
<div class = "content">
    <!-- Title of this page -->
    <h1 class = "text-center">Accounts (Administrator's View)</h1>
        <!-- Title of the employees table as well as generating the physical table -->
        <h2 class = "toc-header text-center" id = "hotels-toc-header">Employees:</h2>
            <div id = "emps-div">
                <?php 
                    $gtv_emps = generate_table_editable($emps_table);
                    echo $gtv_emps;    
                ?>
            </div>
            <!-- Title of the Customers table as well as generating the physical table -->
        <h2 class = "toc-header text-center" id = "users-toc-header">Customers:</h2>
            <div id = "users-div">
            <?php 
                $gtv_users = generate_table_editable($users_table);
                echo $gtv_users;
            ?>
            </div>
        
</div>

<script type="text/javascript" src="<?php echo $backup . "res/toc.js";?>"></script>