<?php
session_start();
include('admin/config/dbcon.php');

if (isset($_POST['verify_btn'])) {
    $entered_otp = $_POST['otp'];
    $stored_data = $_SESSION['temp_user_data'];

    // Verify OTP
    if ($entered_otp == $stored_data['otp']) {
        // Hash password before storing
        $hashed_password = password_hash($stored_data['password'], PASSWORD_DEFAULT);
        
        // Insert user data into database
        $query = "INSERT INTO users (first_name, middle_name, surname, suffix, sex, username, email, mobile_no, 
                                   parish, region_text, province_text, city_text, barangay_text, street_text, zip, 
                                   password, email_verified) 
                 VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $email_verified = 1;
        
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ssssssssssssssssi", 
            $stored_data['first_name'],
            $stored_data['middle_name'],
            $stored_data['surname'],
            $stored_data['suffix'],
            $stored_data['sex'],
            $stored_data['username'],
            $stored_data['email'],
            $stored_data['mobile_no'],
            $stored_data['parish'],
            $stored_data['region'],
            $stored_data['province'],
            $stored_data['city'],
            $stored_data['barangay'],
            $stored_data['street'],
            $stored_data['zip'],
            $hashed_password,
            $email_verified
        );

        if (mysqli_stmt_execute($stmt)) {
            // Clear temporary session data
            unset($_SESSION['temp_user_data']);
            
            $_SESSION['message'] = "Registration successful! Please login.";
            header("Location: login.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Something went wrong: " . mysqli_error($con);
            header("Location: email-verification.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid OTP code. Please try again.";
        header("Location: email-verification.php");
        exit(0);
    }
} else {
    header("Location: register.php");
    exit(0);
}
?> 