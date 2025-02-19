<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$con = mysqli_connect('localhost', 'root', '', 'csv_db 10');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle file upload
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/baptismal/';
if (!file_exists($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        die("Failed to create upload directory");
    }
}

// Initialize $bbirthcert
$bbirthcert = '';

// Handle birth certificate upload
if(isset($_FILES['bcert']) && $_FILES['bcert']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['bcert'];
    $fileName = time() . '_' . basename($file['name']);
    $targetPath = $uploadDir . $fileName;
    
    // Check file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($file['type'], $allowedTypes)) {
        die("Error: Only JPG, JPEG, and PNG files are allowed");
    }
    
    if(move_uploaded_file($file['tmp_name'], $targetPath)) {
        $bbirthcert = $fileName;
    } else {
        die("Error uploading birth certificate: " . error_get_last()['message']);
    }
}

// Retrieve form data
$bapfname = mysqli_real_escape_string($con, $_POST['bapfname']);
$bapmname = mysqli_real_escape_string($con, $_POST['bapmname']);
$baplname = mysqli_real_escape_string($con, $_POST['baplname']);
$bapdbirth = mysqli_real_escape_string($con, $_POST['bapdbirth']);
$bappbirth = mysqli_real_escape_string($con, $_POST['bappbirth']);
$bapnationality = mysqli_real_escape_string($con,  $_POST['bapnationality']);
$ffname = mysqli_real_escape_string($con, $_POST['ffname']);
$fmname = mysqli_real_escape_string($con, $_POST['fmname']);
$flname = mysqli_real_escape_string($con, $_POST['flname']);
$bapfpbirth = mysqli_real_escape_string($con, $_POST['bapfpbirth']);
$fresidence = mysqli_real_escape_string($con, $_POST['fresidence']);
$bapfstatus = mysqli_real_escape_string($con, $_POST['bapfstatus']);
$mfname = mysqli_real_escape_string($con, $_POST['mfname']);
$mmname = mysqli_real_escape_string($con, $_POST['mmname']);
$mlname = mysqli_real_escape_string($con, $_POST['mlname']);
$bapmpbirth = mysqli_real_escape_string($con, $_POST['bapmpbirth']);
$mresidence = mysqli_real_escape_string($con, $_POST['mresidence']);
$bapmstatus = mysqli_real_escape_string($con, $_POST['bapmstatus']);
$mpsponsors = mysqli_real_escape_string($con, $_POST['mpsponsors']);
$fpsponsors = mysqli_real_escape_string($con, $_POST['fpsponsors']);
$sponsors3 = mysqli_real_escape_string($con, $_POST['sponsors3']);
$sponsors4 = mysqli_real_escape_string($con, $_POST['sponsors4']);
$sponsors5 = mysqli_real_escape_string($con, $_POST['sponsors5']);
$sponsors6 = mysqli_real_escape_string($con, $_POST['sponsors6']);
$sponsors7 = mysqli_real_escape_string($con, $_POST['sponsors7']);
$sponsors8 = mysqli_real_escape_string($con, $_POST['sponsors8']);
$bapdatetime = mysqli_real_escape_string($con, $_POST['bapdatetime']);
$baploc = mysqli_real_escape_string($con, $_POST['baploc']);
$bapriest = mysqli_real_escape_string($con, $_POST['bapriest']);
$bapemail = mysqli_real_escape_string($con, $_POST['bapemail']);
$bapcontact = mysqli_real_escape_string($con, $_POST['bapcontact']);
$baptype = mysqli_real_escape_string($con, $_POST['baptype']);
$reserveby = mysqli_real_escape_string($con, $_POST['reserveby']);


// Insert data into database
$query = "INSERT INTO BAPTISM (`catechumen_fname`, `catechumen_mname`, `catechumen_lname`, `date_of_birth`, `place_of_birth`, `nationality`, `father_fname`, `father_mname`, `father_lname`, `father_placeofbirth`, `father_address`, `father_civilstatus`, `mother_fname`, `mother_mname`, `mother_lname`, `mother_placeofbirth`, `mother_address`, `mother_civilstatus`, `p_sponsor(male)`, `p_sponsor(female)`, `sponsor_three`, `sponsor_four`, `sponsor_five`, `sponsor_six`, `sponsor_seven`, `sponsor_eight`, `date_time`, `place_of_baptism`, `priest`, `email`, `contact_no`, `sched_type`, `reserver_name`, `birth_cert`) 
VALUES ('$bapfname', '$bapmname', '$baplname', '$bapdbirth', '$bappbirth', '$bapnationality', '$ffname', '$fmname', '$flname', '$bapfpbirth', '$fresidence', '$bapfstatus', '$mfname', '$mmname', '$mlname', '$bapmpbirth', '$mresidence', '$bapmstatus', '$mpsponsors', '$fpsponsors', '$sponsors3', '$sponsors4', '$sponsors5', '$sponsors6', '$sponsors7', '$sponsors8', '$bapdatetime', '$baploc', '$bapriest', '$bapemail', '$bapcontact', '$baptype', '$reserveby', '$bbirthcert')";


// Execute the query and check for errors
if (mysqli_query($con, $query)) {
    $_SESSION['message'] = "Record added successfully.";
    $_SESSION['form_id'] = mysqli_insert_id($con); // Store the form ID
    header("Location: payments/baptismal-payment.php");
    exit();
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}

// Close connection
mysqli_close($con);

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Error: Invalid request method");
}

if (!isset($_SERVER["CONTENT_TYPE"]) || strpos($_SERVER["CONTENT_TYPE"], "multipart/form-data") === false) {
    die("Error: Form must use multipart/form-data encoding");
}
?>