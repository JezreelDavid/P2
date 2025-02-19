<?php
require_once 'db_connection.php'; // Your database connection file

header('Content-Type: application/json');

try {
    // Validate inputs
    $church_id = (int)$_POST['church_id'];
    $date = $_POST['date'];
    $time_slot_id = (int)$_POST['time_slot_id'];
    $service = $_POST['service'];

    // Start transaction
    $conn->begin_transaction();

    // Insert booking slot
    $stmt = $conn->prepare("INSERT INTO booking_slots (church_id, date, service_type) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $church_id, $date, $service);
    $stmt->execute();
    $booking_slot_id = $conn->insert_id;

    // Insert booking
    $stmt = $conn->prepare("INSERT INTO bookings (booking_slot_id, time_slot_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $booking_slot_id, $time_slot_id);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    // Determine redirect URL based on service type
    $redirect_url = '';
    switch ($service) {
        case 'Baptismal':
            $redirect_url = 'Baptism.php';
            break;
        case 'Wedding':
            $redirect_url = 'Marriage.php';
            break;
        case 'Funeral':
            $redirect_url = 'Burial.php';
            break;
    }

    echo json_encode([
        'success' => true,
        'redirect_url' => $redirect_url . '?booking_id=' . $booking_slot_id
    ]);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

$conn->close(); 