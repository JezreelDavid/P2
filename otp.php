<?php
session_start();

$error_user_otp = '';
$message = '';

if(isset($_SESSION['temp_user_data']))
{
    if(isset($_POST["submit"]))
    {
        if(empty($_POST["otp"]))
        {
            $error_user_otp = 'Enter OTP Number';
        }
        else
        {
            // Compare submitted OTP with stored OTP
            if(trim($_POST["otp"]) == $_SESSION['temp_user_data']['otp'])
            {
                // Include database connection
                include('admin/config/dbcon.php');
                
                // Enable error reporting for debugging
                mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                
                try {
                    // Get user data from session
                    $userData = $_SESSION['temp_user_data'];
                    
                    // Hash the password
                    $password_hash = password_hash($userData['password'], PASSWORD_DEFAULT);
                    
                    // Insert user data into database
                    $query = "INSERT INTO users (first_name, middle_name, surname, suffix, sex, username, 
                             email, mobile_no, parish, region, province, city, barangay, street, zip, password, 
                             email_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'verified')";
                    
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, "sssssssssssssssss",
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
                        $password_hash
                    );

                    if(mysqli_stmt_execute($stmt))
                    {
                        // Clear the temporary session data
                        unset($_SESSION['temp_user_data']);
                        
                        $_SESSION['message'] = "Registration successful! Please login.";
                        header('location: login.php');
                        exit();
                    }
                    else
                    {
                        $message = '<label class="text-danger">Registration failed: ' . mysqli_error($con) . '</label>';
                    }
                } catch (Exception $e) {
                    $message = '<label class="text-danger">Registration failed: ' . $e->getMessage() . '</label>';
                }
            }
            else
            {
                $message = '<label class="text-danger">Invalid OTP Number</label>';
            }
        }
    }
}
else
{
    $_SESSION['message'] = "Please complete registration first";
    header("Location: register.php");
    exit(0);
}
?>