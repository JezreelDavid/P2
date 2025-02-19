<?php
session_start();
include('admin/config/dbcon.php');
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['register_btn'])) {
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $surname = mysqli_real_escape_string($con, $_POST['surname']);
    $suffix = mysqli_real_escape_string($con, $_POST['suffix']);
    $sex = mysqli_real_escape_string($con, $_POST['sex']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile_no = mysqli_real_escape_string($con, $_POST['mobile_no']);
    $parish = mysqli_real_escape_string($con, $_POST['parish']);
    $region = mysqli_real_escape_string($con, $_POST['region_text']);
    $province = mysqli_real_escape_string($con, $_POST['province_text']);
    $city = mysqli_real_escape_string($con, $_POST['city_text']);
    $barangay = mysqli_real_escape_string($con, $_POST['barangay_text']);
    $street = mysqli_real_escape_string($con, $_POST['street_text']);
    $zip = mysqli_real_escape_string($con, $_POST['zip']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    if ($password == $confirm_password) {
        $checkemail = "SELECT email FROM users WHERE email='$email'";
        $checkemail_run = mysqli_query($con, $checkemail);

        if (mysqli_num_rows($checkemail_run) > 0) {
            $_SESSION['message'] = "Email already exists";
            header("Location: register.php");
            exit(0);
        } else {
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999);
            
            // Store user data in session temporarily
            $_SESSION['temp_user_data'] = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'surname' => $surname,
                'suffix' => $suffix,
                'sex' => $sex,
                'username' => $username,
                'email' => $email,
                'mobile_no' => $mobile_no,
                'parish' => $parish,
                'region' => $region,
                'province' => $province,
                'city' => $city,
                'barangay' => $barangay,
                'street' => $street,
                'zip' => $zip,
                'password' => $password,
                'otp' => $otp
            ];

            // Initialize PHPMailer
            $mail = new PHPMailer(true);

            try {
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'pasiginae@gmail.com';
                $mail->Password = 'xkmx bkeu qxjd etbp';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('pasiginae@gmail.com', 'Pasiginae');
                $mail->addAddress($email, $first_name);

                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Registration';
                $mail->Body = "<h1>Your OTP Code</h1><p>Your OTP for registration is: <strong>$otp</strong></p>";

                $mail->send();
                
                // Redirect to OTP verification page
                header("Location: email-verification.php");
                exit(0);

            } catch (Exception $e) {
                $_SESSION['message'] = "Error sending email: {$mail->ErrorInfo}";
                header("Location: register.php");
                exit(0);
            }
        }
    } else {
        $_SESSION['message'] = "Password and Confirm Password do not match";
        header("Location: register.php");
        exit(0);
    }
}
?>