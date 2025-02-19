<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('admin/config/dbcon.php');

// Debug connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if(isset($_POST['submit_marriage'])) {
    // Debug connection more verbosely
    if (!$con) {
        error_log("Database connection failed: " . mysqli_connect_error());
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Add form button name check
    if (!isset($_POST['submit_marriage'])) {
        error_log("Form submission error: submit_marriage button not found");
        $_SESSION['message'] = "Form submission error";
        header("Location: Marriage.php");
        exit(0);
    }

    // Add debug logging
    error_log("Processing marriage form submission");
    error_log("POST data: " . print_r($_POST, true));

    // Create uploads directory if it doesn't exist
    $uploadDir = 'uploads/marriage/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Function to handle file upload
    function handleFileUpload($file, $uploadDir) {
        if(isset($file['name']) && $file['error'] == 0) {
            $fileName = time() . '_' . basename($file['name']);
            $targetPath = $uploadDir . $fileName;
            
            // Check file type
            $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg', 'application/msword', 
                           'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if(in_array($file['type'], $allowedTypes) && move_uploaded_file($file['tmp_name'], $targetPath)) {
                return $fileName;
            }
        }
        return null;
    }

    // Handle file uploads
    $gbaptismal = handleFileUpload($_FILES['gbaptismal'], $uploadDir);
    $bbaptismal = handleFileUpload($_FILES['bbaptismal'], $uploadDir);
    $ChCertificate = handleFileUpload($_FILES['ChCertificate'], $uploadDir);
    $CwCertificate = handleFileUpload($_FILES['CwCertificate'], $uploadDir);
    $hbirthcert = handleFileUpload($_FILES['hbirthcert'], $uploadDir);
    $wbirthcert = handleFileUpload($_FILES['wbirthcert'], $uploadDir);
    $hcenomar = handleFileUpload($_FILES['hcenomar'], $uploadDir);
    $wcenomar = handleFileUpload($_FILES['wcenomar'], $uploadDir);

    // Retrieve form data
    $mhname = mysqli_real_escape_string($con, $_POST['mhname'] ?? '');
    $mwname = mysqli_real_escape_string($con, $_POST['mwname'] ?? '');
    $mhbirth = mysqli_real_escape_string($con, $_POST['mhbirth']);
    $mwbirth = mysqli_real_escape_string($con, $_POST['mwbirth']);
    $mhpbirth = mysqli_real_escape_string($con, $_POST['mhpbirth']);
    $mwpbirth = mysqli_real_escape_string($con, $_POST['mwpbirth']);
    $mhciti = mysqli_real_escape_string($con, $_POST['mhciti']);
    $mwciti = mysqli_real_escape_string($con, $_POST['mwciti']);
    $mhsex = mysqli_real_escape_string($con, $_POST['mhsex']);
    $mwsex = mysqli_real_escape_string($con, $_POST['mwsex']);
    $mhresidence = mysqli_real_escape_string($con, $_POST['mhresidence']);
    $mwresidence = mysqli_real_escape_string($con, $_POST['mwresidence']);
    $mhreligion = mysqli_real_escape_string($con, $_POST['mhreligion']);
    $mwreligion = mysqli_real_escape_string($con, $_POST['mwreligion']);
    $mhstatus = mysqli_real_escape_string($con, $_POST['mhstatus']);
    $mwstatus = mysqli_real_escape_string($con, $_POST['mwstatus']);
    $mhnamefather = mysqli_real_escape_string($con, $_POST['mhnamefather']);
    $mwnamefather = mysqli_real_escape_string($con, $_POST['mwnamefather']);
    $mhcitizenshipfather = mysqli_real_escape_string($con, $_POST['mhcitizenshipfather']);
    $mwcitizenshipfather = mysqli_real_escape_string($con, $_POST['mwcitizenshipfather']);
    $mhnamemother = mysqli_real_escape_string($con, $_POST['mhnamemother']);
    $mwnamemother = mysqli_real_escape_string($con, $_POST['mwnamemother']);
    $mhcitizenshipmother = mysqli_real_escape_string($con, $_POST['mhcitizenshipmother']);
    $mwcitizenshipmother = mysqli_real_escape_string($con, $_POST['mwcitizenshipmother']);
    $mwitness = mysqli_real_escape_string($con, $_POST['mwitness']);
    $fwitness = mysqli_real_escape_string($con, $_POST['fwitness']);
    $mhwrelation = mysqli_real_escape_string($con, $_POST['mhwrelation']);
    $fhwrelation = mysqli_real_escape_string($con, $_POST['fhwrelation']);
    $mresidence = mysqli_real_escape_string($con, $_POST['mresidence']);
    $fresidence = mysqli_real_escape_string($con, $_POST['fresidence']);
    $reserveby = mysqli_real_escape_string($con, $_POST['reserveby']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mnumber = mysqli_real_escape_string($con, $_POST['mnumber']);
    $mnoguest = mysqli_real_escape_string($con, $_POST['mnoguest']);
    $parish = mysqli_real_escape_string($con, $_POST['parish']);
    $priest = mysqli_real_escape_string($con, $_POST['priest']);
    $mdatetime = mysqli_real_escape_string($con, $_POST['mdatetime']);
    $marriagetype = mysqli_real_escape_string($con, $_POST['marriagetype']);

    // Debug form data
    echo "Form data received:<br>";
    print_r($_POST);

    // Insert query
    $query = "INSERT INTO matrimony (
        groom_name, bride_name, dob_groom, dob_bride, 
        pob_groom, pob_bride, citizenship_groom, citizenship_bride,
        gender_groom, gender_bride, address_groom, address_bride,
        religion_groom, religion_bride, status_groom, status_bride,
        fathername_groom, fathername_bride, fathercitizenship_groom, fathercitizenship_bride,
        mothername_groom, mothername_bride, mothercitizenship_groom, mothercitizenship_bride,
        witness_male, witness_female, relation_male, relation_female,
        address_male, address_female, baptismal_groom, baptismal_bride,
        confirmation_groom, confirmation_bride, birthcert_groom, birthcert_bride,
        cenomar_groom, cenomar_bride, reserver_name, email,
        phone_number, no_of_guest, parish, priest, date_time, event_type
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
             ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
             ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);

    // Add error checking for prepared statement
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($con));
        $_SESSION['message'] = "Database error: " . mysqli_error($con);
        header("Location: Marriage.php");
        exit(0);
    }

    // Corrected bind_param with exactly 46 's' parameters to match the number of columns
    mysqli_stmt_bind_param($stmt, str_repeat('s', 46),
        $mhname, $mwname, $mhbirth, $mwbirth,
        $mhpbirth, $mwpbirth, $mhciti, $mwciti,
        $mhsex, $mwsex, $mhresidence, $mwresidence,
        $mhreligion, $mwreligion, $mhstatus, $mwstatus,
        $mhnamefather, $mwnamefather, $mhcitizenshipfather, $mwcitizenshipfather,
        $mhnamemother, $mwnamemother, $mhcitizenshipmother, $mwcitizenshipmother,
        $mwitness, $fwitness, $mhwrelation, $fhwrelation,
        $mresidence, $fresidence, $gbaptismal, $bbaptismal,
        $ChCertificate, $CwCertificate, $hbirthcert, $wbirthcert,
        $hcenomar, $wcenomar, $reserveby, $email,
        $mnumber, $mnoguest, $parish, $priest, $mdatetime, $marriagetype
    );

    // Remove the duplicate bind_param check and simplify the error handling
    if (!mysqli_stmt_bind_param($stmt, str_repeat('s', 46),
        $mhname, $mwname, $mhbirth, $mwbirth,
        $mhpbirth, $mwpbirth, $mhciti, $mwciti,
        $mhsex, $mwsex, $mhresidence, $mwresidence,
        $mhreligion, $mwreligion, $mhstatus, $mwstatus,
        $mhnamefather, $mwnamefather, $mhcitizenshipfather, $mwcitizenshipfather,
        $mhnamemother, $mwnamemother, $mhcitizenshipmother, $mwcitizenshipmother,
        $mwitness, $fwitness, $mhwrelation, $fhwrelation,
        $mresidence, $fresidence, $gbaptismal, $bbaptismal,
        $ChCertificate, $CwCertificate, $hbirthcert, $wbirthcert,
        $hcenomar, $wcenomar, $reserveby, $email,
        $mnumber, $mnoguest, $parish, $priest, $mdatetime, $marriagetype
    )) {
        error_log("Binding parameters failed: " . mysqli_stmt_error($stmt));
        $_SESSION['message'] = "Database error: " . mysqli_stmt_error($stmt);
        header("Location: Marriage.php");
        exit(0);
    }

    // Add error logging before execute
    error_log("Executing statement...");
    $result = mysqli_stmt_execute($stmt);
    
    if(!$result) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        $_SESSION['message'] = "Database error: " . mysqli_stmt_error($stmt);
        header("Location: Marriage.php");
    } else {
        error_log("Statement executed successfully");
        $_SESSION['message'] = "Marriage form submitted successfully!";
        $_SESSION['form_id'] = mysqli_insert_id($con); // Store the form ID
        header("Location: payments/wedding-payment.php");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
    exit(0);
} else {
    $_SESSION['message'] = "Form not submitted properly";
    echo "Form not submitted";
    header("Location: Marriage.php");
    exit(0);
}
?>