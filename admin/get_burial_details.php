<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['burial_record_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['burial_record_id']);
    $query = "SELECT * FROM burial WHERE burial_record_id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if($row) {
        if(isset($_POST['action']) && $_POST['action'] == 'edit') {
            // Return JSON for edit form
            echo json_encode($row);
        } else {
            // Return HTML for view modal
            ?>
            <div class="row">
                <div class="col-md-6">
                    <h5>Deceased Information</h5>
                    <p><strong>Full Name:</strong> <?= $row['full_name'] ?></p>
                    <p><strong>Age:</strong> <?= $row['age'] ?></p>
                    <p><strong>Date of Death:</strong> <?= date('F j, Y', strtotime($row['date_of_death'])) ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Funeral Details</h5>
                    <p><strong>Funeral Date:</strong> <?= date('F j, Y', strtotime($row['funeral_date'])) ?></p>
                    <p><strong>Parish:</strong> <?= $row['parish'] ?></p>
                    <p><strong>Funeral Location:</strong> <?= $row['funeral_location'] ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h5>Reservation Details</h5>
                    <p><strong>Reserved By:</strong> <?= $row['reserver_name'] ?></p>
                    <p><strong>Email:</strong> <?= $row['email'] ?></p>
                    <p><strong>Contact Number:</strong> <?= $row['contact_no'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Documents</h5>
                    <p><strong>Death Certificate:</strong> <?= $row['death_certificate'] ?></p>
                </div>
            </div>
            <?php
        }
    } else {
        echo "Record not found";
    }
}
?> 