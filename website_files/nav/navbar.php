<nav class="navtop navbar navbar-expand-md navbar-dark navbar-inverse">
    <div class = "container-fluid">
        <div class = "navbar-header">
            <a class = "nav-link" href="<?php echo $backup . "login/home.php"?>">Hotel Magnagement System (HMS)</a>
        </div>
        <div class = "collapse navbar-collapse">
            <ul class = "navbar-nav">
                <li class="nav-item dropdown">
                    <a class = "nav-link" href="<?php echo $backup . "bookings/bookings.php"?>">
                        Bookings

                    <?php 
                    // If we are an administrator or receptionist, grant access to the receptionist view of bookings page
                    if ($_SESSION["employee_jobtype"] === "Administrator" || $_SESSION["employee_jobtype"] === "Receptionist") {
                            ?>
                        <i class="fa fa-caret-down nav-carat"></i>
                        </a>
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
                    <a class = "nav-link" href="<?php echo $backup . "login/profile.php"?>"><i class="fas fa-user-circle"></i>Profile

                    <?php 
                
                    // If we are an administrator, grant access to the administrator view of reviews page
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
                    <a class = "nav-link" href="<?php echo $backup . "login/logout.php"?>"><i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>