<?php
session_start();
include('admin/config/dbcon.php');

if (!isset($_SESSION['temp_user_data'])) {
    header("Location: register.php");
    exit(0);
}

if (isset($_POST['otp'])) {
    $submittedOtp = implode('', $_POST['otp']);
    $storedOtp = $_SESSION['temp_user_data']['otp'];

    if ($submittedOtp == $storedOtp) {
        // Get user data from session
        $userData = $_SESSION['temp_user_data'];
        
        // Hash the password
        $hashed_password = password_hash($userData['password'], PASSWORD_BCRYPT);

        // Insert user into database
        $user_query = "INSERT INTO users (first_name, middle_name, surname, suffix, sex, username, email, 
                                        mobile_no, parish, region_text, province_text, city_text, 
                                        barangay_text, street_text, zip, password) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                      
        $stmt = mysqli_prepare($con, $user_query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssss", 
            $userData['first_name'],
            $userData['middle_name'],
            $userData['surname'],
            $userData['suffix'],
            $userData['sex'],
            $userData['username'],
            $userData['email'],
            $userData['mobile_no'],
            $userData['parish'],
            $userData['region'],
            $userData['province'],
            $userData['city'],
            $userData['barangay'],
            $userData['street'],
            $userData['zip'],
            $hashed_password
        );

        if (mysqli_stmt_execute($stmt)) {
            // Clear temporary session data
            unset($_SESSION['temp_user_data']);
            
            $_SESSION['message'] = "Registration successful! Please login.";
            header("Location: login.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Database error occurred";
            header("Location: register.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid OTP. Please try again.";
        header("Location: otp.php");
        exit(0);
    }
}
?>
