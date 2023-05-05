<!---------------------------------------------------------------------------------------------- 
Author of code: Yaroub Hussein

Yaroub was responsible for coding this entire file.

This file ends the session that a user starts when they log in, and redirects the user back to the login page.
----------------------------------------------------------------------------------------------->

<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: login.php');
?>