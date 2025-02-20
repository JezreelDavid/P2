<?php
$servername = "localhost";  // replace with your server details
$username = "root";         // replace with your database username
$password = "";             // replace with your database password
$dbname = "u493132415_pasiginaenae"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select the database explicitly (if you're using a different connection method)
mysqli_select_db($conn, $dbname);
?>
