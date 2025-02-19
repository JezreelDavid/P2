<?php
include('admin/config/dbcon.php');
session_start();

// Add use statements at the top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Reset step when directly accessing the page
if (!isset($_POST['verify_email']) && !isset($_POST['verify_otp']) && !isset($_POST['reset_password'])) {
    $_SESSION['step'] = 1;
    unset($_SESSION['reset_email']);
    unset($_SESSION['otp']);
}

// Handle Step 1 verification
if (isset($_POST['verify_email'])) {
    $email = $_POST['email'];
    
    // Check if email exists
    $checkEmail = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($checkEmail) > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp'] = $otp;
        $_SESSION['step'] = 2;

        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'pasiginae@gmail.com';
            $mail->Password = 'xkmx bkeu qxjd etbp';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('pasiginae@gmail.com', 'Jesus Christ your Savior amen');
            $mail->addAddress($email,);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: <b>$otp</b>";

            $mail->send();
        } catch (Exception $e) {
            $error = "Failed to send OTP. Please try again.";
            $_SESSION['step'] = 1;
        }
    } else {
        $error = "Email not found in our records!";
    }
}

// Handle Step 2 OTP verification
if (isset($_POST['verify_otp'])) {
    $entered_otp = $_POST['otp'];
    if ($entered_otp == $_SESSION['otp']) {
        $_SESSION['step'] = 3;
    } else {
        $error = "Invalid OTP!";
    }
}

// Handle Step 3 password reset (previously Step 2)
if (isset($_POST['reset_password'])) {
    $email = $_SESSION['reset_email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword == $confirmPassword) {
        // Hash password before storing
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = mysqli_query($con, "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'");
        
        if ($updateQuery) {
            unset($_SESSION['reset_email']);
            unset($_SESSION['step']);
            unset($_SESSION['otp']);
            echo "<script>alert('Password updated successfully!'); window.location.href='login.php';</script>";
        } else {
            $error = "Failed to update password.";
        }
    } else {
        $error = "Passwords do not match!";
    }
}

// Set default step
if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="assets/CSS/styless.css">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
</head>
<body class="bg-light">
    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row justify-content-center w-100">
            <div class="col-lg-4 col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="assets/img/logo.png" alt="Logo" width="80">
                            <h4 class="mt-3">Reset Password</h4>
                        </div>

                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if($_SESSION['step'] == 1): ?>
                        <!-- Step 1 -->
                        <form action="" method="POST">
                            <div class="step-indicator mb-4">
                                <div class="fw-bold text-primary mb-2">Step 1</div>
                                <div class="small text-muted mb-3">Verify your email address</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Email</label>
                                <input required placeholder="Enter Email" class="form-control" type="email" name="email">
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="verify_email" class="btn btn-primary">Continue</button>
                            </div>
                        </form>

                        <?php elseif($_SESSION['step'] == 2): ?>
                        <!-- Step 2 - OTP Verification -->
                        <form action="" method="POST">
                            <div class="step-indicator mb-4">
                                <div class="fw-bold text-primary mb-2">Step 2</div>
                                <div class="small text-muted mb-3">Enter the OTP sent to your email</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">OTP</label>
                                <input required placeholder="Enter OTP" class="form-control" type="number" name="otp">
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="verify_otp" class="btn btn-primary">Verify OTP</button>
                                <a href="forgot-password.php?step=1" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </form>

                        <?php else: ?>
                        <!-- Step 3 -->
                        <form action="" method="POST">
                            <div class="step-indicator mb-4">
                                <div class="fw-bold text-primary mb-2">Step 3</div>
                                <div class="small text-muted mb-3">Create new password</div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input required placeholder="Enter New Password" class="form-control" type="password" name="new_password">
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input required placeholder="Confirm New Password" class="form-control" type="password" name="confirm_password">
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>
                                <a href="forgot-password.php?step=1" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </form>
                        <?php endif; ?>

                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none">Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
