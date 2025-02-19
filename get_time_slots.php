<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u493132415_pasiginaenae";

// Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $conn->connect_error]));
}

// Get parameters
$service = isset($_GET['service']) ? $_GET['service'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (empty($service) || empty($date)) {
    die(json_encode(['error' => 'Missing required parameters']));
}

// Define service-specific time slots
$serviceTimeSlots = [
    'Wedding' => [
        '10:00:00' => ['max_slots' => 1],
        '13:30:00' => ['max_slots' => 1],
        '15:30:00' => ['max_slots' => 1]
    ],
    'Baptismal' => [
        '08:00:00' => ['max_slots' => 10],
        '11:30:00' => ['max_slots' => 10]
    ],
    'Funeral' => [
        '13:00:00' => ['max_slots' => 3],
        '14:00:00' => ['max_slots' => 3],
        '15:00:00' => ['max_slots' => 3]
    ]
];

// Check if service exists
if (!isset($serviceTimeSlots[$service])) {
    die(json_encode(['error' => 'Invalid service type']));
}

// Get booked slots for the date and service
$sql = "SELECT time_slot, COUNT(*) as booked_count 
        FROM bookings 
        WHERE date = ? 
        AND service_type = ? 
        AND status != 'cancelled'
        GROUP BY time_slot";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $date, $service);
$stmt->execute();
$result = $stmt->get_result();

$bookedSlots = [];
while ($row = $result->fetch_assoc()) {
    $bookedSlots[$row['time_slot']] = $row['booked_count'];
}

// Prepare response with available slots
$response = [];
foreach ($serviceTimeSlots[$service] as $time => $config) {
    $booked = isset($bookedSlots[$time]) ? $bookedSlots[$time] : 0;
    $available = $config['max_slots'] - $booked;
    
    $response[$time] = [
        'max_slots' => $config['max_slots'],
        'booked_slots' => $booked,
        'available_slots' => max(0, $available)
    ];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?> 