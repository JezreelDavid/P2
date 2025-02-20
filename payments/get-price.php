<?php
require 'dbConnection.php';

if (isset($_GET['service_id']) && isset($_GET['parish_id'])) {
    $service_id = $_GET['service_id'];
    $parish_id = $_GET['parish_id'];

    $sql = "SELECT amount FROM Prices WHERE service_id = ? AND parish_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $service_id, $parish_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['amount' => $row['amount']]);
    } else {
        echo json_encode(['amount' => '0.00']);
    }
} else {
    echo json_encode(['amount' => '0.00']);
}
