<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['baptism_record_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['baptism_record_id']);
    
    // Use prepared statement for security
    $query = "SELECT * FROM baptism WHERE baptism_record_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if($row = mysqli_fetch_assoc($result)) {
        if(isset($_POST['action']) && $_POST['action'] === 'edit') {
            // For edit requests, return JSON
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            // For view requests, return HTML
            ?>
            <div class="row">
                <div class="col-md-6">
                    <h5>Catechumen Information</h5>
                    <p><strong>Name:</strong> <?= htmlspecialchars($row['catechumen_fname'] . ' ' . $row['catechumen_mname'] . ' ' . $row['catechumen_lname']) ?></p>
                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($row['date_of_birth']))) ?></p>
                    <p><strong>Place of Birth:</strong> <?= htmlspecialchars($row['place_of_birth']) ?></p>
                    <p><strong>Nationality:</strong> <?= htmlspecialchars($row['nationality']) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Baptism Details</h5>
                    <p><strong>Date & Time:</strong> <?= htmlspecialchars(date('F j, Y g:i A', strtotime($row['date_time']))) ?></p>
                    <p><strong>Place of Baptism:</strong> <?= htmlspecialchars($row['place_of_baptism']) ?></p>
                    <p><strong>Priest:</strong> <?= htmlspecialchars($row['priest']) ?></p>
                    <p><strong>Schedule Type:</strong> <?= htmlspecialchars($row['sched_type']) ?></p>
                    <p><strong>Reserved By:</strong> <?= htmlspecialchars($row['reserver_name']) ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo "Record not found";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Invalid request";
}
?> 