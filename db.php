<?php
$servername = "your_host";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
