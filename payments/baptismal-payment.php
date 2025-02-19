<?php
require_once 'includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Generate ticket code
        $ticketCode = generateTicketCode();
        
        // Get current date in MySQL format
        $paymentDate = date('Y-m-d H:i:s');
        
        // Prepare payment data
        $paymentData = [
            'user_id' => $_SESSION['user_id'] ?? 0,
            'ticket_code' => $ticketCode,
            'payment_method' => $_POST['payment_method'],
            'amount' => $_POST['amount'],
            'service_type' => 'baptismal', // Set specific service type
            'status' => 'pending',
            'payment_date' => $paymentDate
        ];
        
        // Connect to database
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare SQL statement
        $sql = "INSERT INTO payments (user_id, ticket_code, payment_method, amount, service_type, status, payment_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
                
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("issdsss",
            $paymentData['user_id'],
            $paymentData['ticket_code'],
            $paymentData['payment_method'],
            $paymentData['amount'],
            $paymentData['service_type'],
            $paymentData['status'],
            $paymentData['payment_date']
        );
        
        // Execute the statement
        if ($stmt->execute()) {
            // Send email notification
            sendTicketEmail($_POST['email'], $ticketCode, $_POST);
            
            // Return success response
            echo json_encode([
                'success' => true,
                'ticket_code' => $ticketCode
            ]);
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'An error occurred while processing your payment.'
        ]);
    }
    exit;
}
?>