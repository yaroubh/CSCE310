<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
# set credentials
$servername='localhost';
$username='root';
$password='';
$dbname = "test";
# make connection
$conn = new mysqli($servername,$username,$password,"$dbname");
if(!$conn){
    die('Could not Connect MySql Server:' . $conn -> connect_error);
} else {
    # print("success!");
}

# Get the base path of the file and ignore everything else. We can use this to easily navigate to other files
$path = getcwd() . "/";
$path = str_replace('\\', '/', $path);
$path_parts = explode('/website_files/', $path);
#  foreach ($path_parts as $path_part) {
#      echo "<p>Part: " . $path_part . "</p>";
#  }
$local_path = array_pop($path_parts);
$folder_depth = substr_count($local_path, "/");
$backup = "";
for ($i = 0; $i < $folder_depth; $i++) {
    $backup .= "../";
}
# echo "<p>Backup: " . $backup . "</p>";
# echo "<p>Folder Depth: " . $folder_depth . "</p>";
include $backup . "nav/navbar.php";
include $backup . "res/table_editor.php"; 
?>

<!doctype html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo $backup . "res/main.css";?>" type="text/css">
<!--<link rel="stylesheet" href="res/main.css">-->
<title>Hotel Management System</title>
