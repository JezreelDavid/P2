<?php
require 'config.php';

// Check if composer autoload exists
$autoloadPath = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
}

function generateTicketCode() {
    return strtoupper(uniqid('TKT'));
}

function savePayment($userId, $ticketCode, $paymentMethod, $amount, $serviceType) {
    $conn = new mysqli('localhost', 'root', '', 'csv_db 10');
    
    $stmt = $conn->prepare("INSERT INTO payments (user_id, ticket_code, payment_method, amount, service_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $userId, $ticketCode, $paymentMethod, $amount, $serviceType);
    
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    
    return $result;
}

function sendTicketEmail($email, $ticketCode, $paymentDetails) {
    // Check if PHPMailer is available
    if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        error_log('PHPMailer not installed. Email not sent.');
        return false;
    }

    try {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pasiginae@gmail.com';
        $mail->Password = 'xkmx bkeu qxjd etbp';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pasiginae@gmail.com', 'Church Payment System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Payment Ticket Confirmation';
        $mail->Body = "
            <h2>Payment Confirmation</h2>
            <p>Your payment has been received. Here are your details:</p>
            <p><strong>Ticket Code:</strong> {$ticketCode}</p>
            <p><strong>Amount:</strong> ₱{$paymentDetails['amount']}</p>
            <p><strong>Service:</strong> {$paymentDetails['service']}</p>
            <p>Please keep this ticket code for your records.</p>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: {$mail->ErrorInfo}");
        return false;
    }
} 