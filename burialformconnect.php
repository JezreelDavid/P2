<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'csv_db 10');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle file upload
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/burial/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Failed to create upload directory");
    }
}

// Initialize $bdeathcert
$bdeathcert = '';

// Handle death certificate upload
if(isset($_FILES['bdeathcert']) && $_FILES['bdeathcert']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['bdeathcert'];
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Check file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Error: Only PDF, JPG, JPEG, and PNG files are allowed");
    }
    
    if(move_uploaded_file($file['tmp_name'], $targetPath)) {
        $bdeathcert = $fileName;
    } else {
        die("Error uploading death certificate: " . error_get_last()['message']);
    }
}

// Capture form data and sanitize inputs
$bname = mysqli_real_escape_string($con, $_POST['bname'] ?? '');
$bage = mysqli_real_escape_string($con, $_POST['bage'] ?? '');
$bdatedeath = mysqli_real_escape_string($con, $_POST['bdatedeath'] ?? '');
$bdatetime = mysqli_real_escape_string($con, $_POST['bdatetime'] ?? '');
$bparish = mysqli_real_escape_string($con, $_POST['bparish'] ?? '');
$blfuneral = mysqli_real_escape_string($con, $_POST['blfuneral'] ?? '');
$breserve = mysqli_real_escape_string($con, $_POST['breserve'] ?? '');
$bemail = mysqli_real_escape_string($con, $_POST['bemail'] ?? '');
$bcontact = mysqli_real_escape_string($con, $_POST['bcontact'] ?? '');

// Insert data into the burial table
$query = "INSERT INTO BURIAL (full_name, age, date_of_death, funeral_date, parish, funeral_location, reserver_name, email, contact_no, death_certificate) 
VALUES ('$bname', '$bage', '$bdatedeath', '$bdatetime', '$bparish', '$blfuneral', '$breserve', '$bemail', '$bcontact', '$bdeathcert')";

// Execute the query and check for errors
if (mysqli_query($con, $query)) {
    $_SESSION['message'] = "Record added successfully.";
    $_SESSION['form_id'] = mysqli_insert_id($con); // Store the form ID
    header("Location: payments/burial-payment.php");
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}

// Close connection
mysqli_close($con);
?>