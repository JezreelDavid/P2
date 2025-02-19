
// process-payment.php
<?php
session_start();
require 'dbConnection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = $_POST['service_id'];
    $parish_id = $_POST['parish_id'];
    $amount = $_POST['amount'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in

    // Validate amount against price in database
    $sql = "SELECT amount FROM Prices WHERE service_id = ? AND parish_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $service_id, $parish_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if($amount == $row['amount']) {
        // Insert payment record
        $sql = "INSERT INTO payments (user_id, service_id, parish_id, amount) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $user_id, $service_id, $parish_id, $amount);
        
        if($stmt->execute()) {
            $_SESSION['payment_success'] = true;
            header('Location: payment-success.php');
        } else {
            $_SESSION['payment_error'] = "Payment failed to process";
            header('Location: payment-system.php');
        }
    } else {
        $_SESSION['payment_error'] = "Invalid amount";
        header('Location: payment-system.php');
    }
}