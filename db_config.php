<?php
$host = "sql105.infinityfree.com";
$user = "if0_38611818";  
$pass = "G3qGqzf0wjjY";      
$db = "if0_38611818_tiffin_service"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
