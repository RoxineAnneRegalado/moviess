<?php
$servername = "localhost";
$username = "roxine";
$password = "@roxine123!";
$dbname = "db_movies";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
