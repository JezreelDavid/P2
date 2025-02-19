<?php
require_once 'db_connection.php'; // Create this file with your database connection code

$date = $_GET['date'] ?? null;
$service = $_GET['service'] ?? null;
$time = $_GET['time'] ?? null;

if (!$date || !$service || !$time) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

// Get available slots
$sql = "SELECT sts.max_slots - COUNT(b.id) as available_slots
        FROM service_time_slots sts
        LEFT JOIN bookings b ON b.service_type = sts.service_type 
            AND b.time_slot = sts.time_slot 
            AND b.date = ?
            AND b.status != 'cancelled'
        WHERE sts.service_type = ?
            AND sts.time_slot = ?
        GROUP BY sts.time_slot";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $date, $service, $time);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode([
    'available_slots' => $row ? $row['available_slots'] : 0
]); 

function getDateAvailability($conn, $date, $church_id) {
    $sql = "SELECT 
                sts.service_type,
                sts.time_slot,
                sts.max_slots,
                COUNT(b.id) as booked_slots,
                sts.max_slots - COUNT(b.id) as available_slots
            FROM service_time_slots sts
            LEFT JOIN bookings b ON b.service_type = sts.service_type 
                AND b.time_slot = sts.time_slot 
                AND b.date = ?
                AND b.church_id = ?
                AND b.status != 'cancelled'
            GROUP BY sts.service_type, sts.time_slot";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $date, $church_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $availability = [];
    while ($row = $result->fetch_assoc()) {
        $availability[$row['service_type']][$row['time_slot']] = [
            'max' => $row['max_slots'],
            'booked' => $row['booked_slots'],
            'available' => $row['available_slots']
        ];
    }
    
    return $availability;
} 