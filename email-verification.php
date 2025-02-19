<?php
session_start();

// Redirect if no temporary user data exists
if (!isset($_SESSION['temp_user_data'])) {
    $_SESSION['message'] = "Please register first";
    header("Location: register.php");
    exit(0);
}

include "includes/header.php";
?>

<div class="container py-5">
    <?php include('message.php'); ?>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Email Verification</h4>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
                        <p class="text-muted">Please enter the verification code sent to your email address</p>
                    </div>
                    <form action="verify-email.php" method="POST">
                        <div class="form-group mb-4">
                            <div class="otp-input-container">
                                <input type="text" name="otp" 
                                    class="form-control form-control-lg text-center" 
                                    required 
                                    maxlength="6" 
                                    pattern="[0-9]{6}"
                                    placeholder="000000"
                                    style="letter-spacing: 0.5em; font-size: 1.5rem;">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button type="submit" name="verify_btn" 
                                class="btn btn-primary btn-lg w-100">
                                Verify Email
                            </button>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">
                                Didn't receive the code? 
                                <a href="#" class="text-decoration-none">Resend</a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?> 