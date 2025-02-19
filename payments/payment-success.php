
// payment-success.php
<?php
session_start();
if(!isset($_SESSION['payment_success'])) {
    header('Location: payment-system.php');
    exit();
}
unset($_SESSION['payment_success']);
?>

<!DOCTYPE html>
<html data-theme="light">
<head>
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.7.3/dist/full.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content text-center">
            <div class="max-w-md">
                <h1 class="text-5xl font-bold">Payment Successful!</h1>
                <p class="py-6">Your payment has been processed successfully.</p>
                <a href="payment-system.php" class="btn btn-primary">Make Another Payment</a>
            </div>
        </div>
    </div>
</body>
</html>