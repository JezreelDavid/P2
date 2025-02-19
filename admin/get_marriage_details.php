<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['marriage_record_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['marriage_record_id']);
    $query = "SELECT * FROM matrimony WHERE marriage_record_id = '$id'";
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
                    <h5>Groom Details</h5>
                    <p><strong>Name:</strong> <?= $row['groom_name'] ?></p>
                    <p><strong>Date of Birth:</strong> <?= $row['dob_groom'] ?></p>
                    <p><strong>Place of Birth:</strong> <?= $row['pob_groom'] ?></p>
                    <p><strong>Citizenship:</strong> <?= $row['citizenship_groom'] ?></p>
                    <p><strong>Gender:</strong> <?= $row['gender_groom'] ?></p>
                    <p><strong>Address:</strong> <?= $row['address_groom'] ?></p>
                    <p><strong>Religion:</strong> <?= $row['religion_groom'] ?></p>
                    <p><strong>Civil Status:</strong> <?= $row['status_groom'] ?></p>
                    <p><strong>Father's Name:</strong> <?= $row['fathername_groom'] ?></p>
                    <p><strong>Father's Citizenship:</strong> <?= $row['fathercitizenship_groom'] ?></p>
                    <p><strong>Mother's Name:</strong> <?= $row['mothername_groom'] ?></p>
                    <p><strong>Mother's Citizenship:</strong> <?= $row['mothercitizenship_groom'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Bride Details</h5>
                    <p><strong>Name:</strong> <?= $row['bride_name'] ?></p>
                    <p><strong>Date of Birth:</strong> <?= $row['dob_bride'] ?></p>
                    <p><strong>Place of Birth:</strong> <?= $row['pob_bride'] ?></p>
                    <p><strong>Citizenship:</strong> <?= $row['citizenship_bride'] ?></p>
                    <p><strong>Gender:</strong> <?= $row['gender_bride'] ?></p>
                    <p><strong>Address:</strong> <?= $row['address_bride'] ?></p>
                    <p><strong>Religion:</strong> <?= $row['religion_bride'] ?></p>
                    <p><strong>Civil Status:</strong> <?= $row['status_bride'] ?></p>
                    <p><strong>Father's Name:</strong> <?= $row['fathername_bride'] ?></p>
                    <p><strong>Father's Citizenship:</strong> <?= $row['fathercitizenship_bride'] ?></p>
                    <p><strong>Mother's Name:</strong> <?= $row['mothername_bride'] ?></p>
                    <p><strong>Mother's Citizenship:</strong> <?= $row['mothercitizenship_bride'] ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h5>Witnesses</h5>
                    <p><strong>Male Witness:</strong> <?= $row['witness_male'] ?></p>
                    <p><strong>Male Witness Relation:</strong> <?= $row['relation_male'] ?></p>
                    <p><strong>Male Witness Address:</strong> <?= $row['address_male'] ?></p>
                    <p><strong>Female Witness:</strong> <?= $row['witness_female'] ?></p>
                    <p><strong>Female Witness Relation:</strong> <?= $row['relation_female'] ?></p>
                    <p><strong>Female Witness Address:</strong> <?= $row['address_female'] ?></p>
                </div>
                <div class="col-md-6">
                    <h5>Ceremony Details</h5>
                    <p><strong>Parish:</strong> <?= $row['parish'] ?></p>
                    <p><strong>Priest:</strong> <?= $row['priest'] ?></p>
                    <p><strong>Date & Time:</strong> <?= date('F j, Y g:i A', strtotime($row['date_time'])) ?></p>
                    <p><strong>Event Type:</strong> <?= $row['event_type'] ?></p>
                    <p><strong>Number of Guests:</strong> <?= $row['no_of_guest'] ?></p>
                    <p><strong>Reserved By:</strong> <?= $row['reserver_name'] ?></p>
                    <p><strong>Contact Number:</strong> <?= $row['phone_number'] ?></p>
                    <p><strong>Email:</strong> <?= $row['email'] ?></p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h5>Documents</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Groom's Documents</h6>
                            <p><strong>Baptismal Certificate:</strong> <?= $row['baptismal_groom'] ?></p>
                            <p><strong>Confirmation Certificate:</strong> <?= $row['confirmation_groom'] ?></p>
                            <p><strong>Birth Certificate:</strong> <?= $row['birthcert_groom'] ?></p>
                            <p><strong>CENOMAR:</strong> <?= $row['cenomar_groom'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Bride's Documents</h6>
                            <p><strong>Baptismal Certificate:</strong> <?= $row['baptismal_bride'] ?></p>
                            <p><strong>Confirmation Certificate:</strong> <?= $row['confirmation_bride'] ?></p>
                            <p><strong>Birth Certificate:</strong> <?= $row['birthcert_bride'] ?></p>
                            <p><strong>CENOMAR:</strong> <?= $row['cenomar_bride'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "Record not found";
    }
}
?> 