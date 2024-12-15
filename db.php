<?php
$servername = "localhost";
$username = "adminroxine";
$password = "@Adminroxine123!";
$dbname = "movies_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
