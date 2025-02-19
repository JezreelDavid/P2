<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['baptism_record_id']) && isset($_POST['action'])) {
    $id = mysqli_real_escape_string($con, $_POST['baptism_record_id']);
    
    if($_POST['action'] == 'edit') {
        $query = "SELECT * FROM baptism WHERE baptism_record_id = '$id'";
        $result = mysqli_query($con, $query);
        
        if($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Record not found']);
        }
        exit();
    }
}

header('HTTP/1.1 400 Bad Request');
echo json_encode(['error' => 'Invalid request']);
exit();
?>