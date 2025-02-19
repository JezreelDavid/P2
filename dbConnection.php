<?php
$servername = "localhost"; // Check if you need to update this from Hostinger's database settings
$username = "u493132415_binary101"; // Double-check username
$password = "Pasiginae101"; // Double-check password
$database = "u493132415_pasiginaenae"; // Ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>