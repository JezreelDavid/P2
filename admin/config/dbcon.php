<?php 

$host = "localhost"; // Check if you need to update this from Hostinger's database settings
$username = "root"; // Double-check username
$password = ""; // Double-check password
$database = "csv_db 10"; // Ensure this is the correct database name

// Establish connection
$con = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$con) {
    // Log the error for debugging (better than showing it to users in production)
    error_log("Database connection error: " . mysqli_connect_error());
    
    // Redirect to a custom error page
    header("Location: ../errors/dberror.php");
    exit(); // Stop further execution
}

?>