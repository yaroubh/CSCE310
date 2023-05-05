<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein, Jacob Enrino, Uchenna Akahara

Yaroub was responsible for coding the frame and setting up the navbar, constructing the buttons, and the functionalities of the Profile button at lines 11-18, and 66-92.
Jacob  was responsible for coding the Bookings button functionality at lines 19-41.
Uchenna was responsible for coding the Reviews button functionality at lines 46-61. 

This file holds the basic HTML and PHP framework and content that the navigation bar at the top of each page holds, as well as handling functionality of the buttons
and their abilites to redirect to other pages. This file also checks the current user type and shows a different navigation bar with different accesses depending on the user type.

----------------------------------------------------------------------------------------------->

<nav class="navtop navbar navbar-expand-md navbar-dark navbar-inverse">
    <div class = "container-fluid">
        <div class = "navbar-header">
            <!-- Title of the website and project (Yaroub wrote this section and formatted the navigation bar) -->
            <a class = "nav-link" href="<?php echo $backup . "login/home.php"?>">Hotel Magnagement System (HMS)</a>
        </div>
        <div class = "collapse navbar-collapse">
            <ul class = "navbar-nav">
                <li class="nav-item dropdown">
                    <!-- The Bookings button (Jacob wrote this section)-->
                    <a class = "nav-link" href="<?php echo $backup . "bookings/bookings.php"?>">
                        Bookings

                    <?php 
                    // If we are an administrator or receptionist, grant access to the receptionist view of bookings page
                    if ($_SESSION["employee_jobtype"] === "Administrator" || $_SESSION["employee_jobtype"] === "Receptionist") {
                            ?>
                        <i class="fa fa-caret-down nav-carat"></i>
                        </a>
                        <!-- the different drop down menu options for Bookings button -->
                        <ul class="dropdown-menu">
                            <li class = ""><a class = "nav-link" href = <?php echo $backup . "bookings/bookings_receptionist.php"?>>Bookings (Receptionist View)</a></li>
                            <?php 
                            // If we are an administrator, grant access to the administrator view of bookings page
                            if ($_SESSION["employee_jobtype"] === "Administrator") { 
                                ?>
                            <li class = ""><a class = "nav-link" href = <?php echo $backup . "bookings/bookings_admin.php"?>>Bookings (Administrator View)</a></li>  
 
                            <?php } ?>                            
                        </ul>
                    <?php } else { ?>
                        </a>
                    <?php } ?>
                </li>



                    <li class = "nav-item dropdown">
                        <!-- The Reviews button and its function (Uchenna wrote this section)-->
                    <a class = "nav-link" href="<?php echo $backup . "reviews/hotel_reviews.php"?>"><i class="fas"></i>Reviews
                <?php 
                
                    // If we are an administrator, grant access to the administrator view of reviews page
                    if ($_SESSION["employee_jobtype"] === "Administrator") { 
                        ?>
                        <i class="fa fa-caret-down nav-carat"></i>
                        </a>
                        <ul class = "dropdown-menu">
                            <li class = ""><a class = "nav-link" href = <?php echo $backup . "reviews/hotel_reviews_admin.php"?>>Reviews (Administrator View)</a></li>   
                        </ul>

                <?php } else{ ?>      
                    </a>             
                 <?php } ?>

                 
                
            </ul>

            <ul class = "nav navbar-nav ml-auto">
                <li class = "nav-item dropdown">
                    <!-- The Profile Button and its function (Yaroub wrote this section) -->
                    <a class = "nav-link" href="<?php echo $backup . "login/profile.php"?>"><i class="fas fa-user-circle"></i>Profile

                    <?php 
                
                    // If we are an administrator, grant access to the administrator view of Profile page showing all accounts and their relevant info registered
                    if ($_SESSION["employee_jobtype"] === "Administrator") { 
                        ?>
                        <i class="fa fa-caret-down nav-carat"></i>
                        </a>
                        <ul class = "dropdown-menu">
                            <li class = ""><a class = "nav-link" href = <?php echo $backup . "login/admin_accounts.php"?>>Accounts (Administrator View)</a></li>   
                        </ul>

                    <?php } else{ ?>      
                        </a>             
                    <?php } ?>

                </li>
                <li class = "nav-item">
                    <!-- The log out button and its function (Yaroub wrote this section) -->
                    <a class = "nav-link" href="<?php echo $backup . "login/logout.php"?>"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>