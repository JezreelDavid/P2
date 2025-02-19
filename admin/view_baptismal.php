<?php
session_start();
include('config/dbcon.php');

// Check if user is logged in and is an admin
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != "1") {
    header("Location: ../login.php");
    exit(0);
}


if(isset($_POST['baptism_record_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['baptism_record_id']);
    $query = "SELECT *, 
              DATE_FORMAT(date_time, '%Y-%m-%dT%H:%i') as date_time 
              FROM baptism 
              WHERE baptism_record_id = '$id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    if($row) {
        if(isset($_POST['action']) && $_POST['action'] == 'edit') {
            header('Content-Type: application/json');
            $row = array_map(function($value) {
                return $value === null ? "" : $value;
            }, $row);
            echo json_encode($row);
            exit();
        } else {
            ?>
            <div class="row">
                <div class="col-md-4">
                    <h5>Catechumen Information</h5>
                    <p><strong>Name:</strong> <?= $row['catechumen_fname'] . ' ' . $row['catechumen_mname'] . ' ' . $row['catechumen_lname'] ?></p>
                    <p><strong>Date of Birth:</strong> <?= date('F j, Y', strtotime($row['date_of_birth'])) ?></p>
                    <p><strong>Place of Birth:</strong> <?= $row['place_of_birth'] ?></p>
                    <p><strong>Nationality:</strong> <?= $row['nationality'] ?></p>
                </div>
                <!-- Add more sections for parents, sponsors, etc. -->
            </div>
            <?php
        }
    }
}

include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Baptismal Records</h4>
        </div>
        <div class="card-body">
            <?php 
            // ... (same session message handling) ...
            ?>
            <table id="baptismalTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Catechumen Name</th>
                        <th>Date of Birth</th>
                        <th>Date/Time of Baptism</th>
                        <th>Place of Baptism</th>
                        <th>Priest</th>
                        <th>Reserved By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT b.*, u.email as user_email 
                             FROM baptism b 
                             LEFT JOIN users u ON b.user_id = u.id 
                             ORDER BY b.date_time DESC";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0) {
                        foreach($query_run as $row) {
                            ?>
                            <tr>
                                <td><?= $row['baptism_record_id'] ?></td>
                                <td><?= $row['catechumen_fname'] . ' ' . $row['catechumen_mname'] . ' ' . $row['catechumen_lname'] ?></td>
                                <td><?= date('F j, Y', strtotime($row['date_of_birth'])) ?></td>
                                <td><?= date('F j, Y g:i A', strtotime($row['date_time'])) ?></td>
                                <td><?= $row['place_of_baptism'] ?></td>
                                <td><?= $row['priest'] ?></td>
                                <td><?= $row['reserver_name'] ?></td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-primary btn-sm view-baptismal" data-id="<?= $row['baptism_record_id'] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm edit-baptismal" data-id="<?= $row['baptism_record_id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-baptismal" data-id="<?= $row['baptism_record_id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewDetailsModalLabel">Baptismal Record Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewDetailsContent">
                <!-- Content will be loaded here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Baptismal Modal -->
<div class="modal fade" id="editBaptismalModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Baptismal Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editBaptismalForm">
                    <input type="hidden" name="baptism_id" id="edit_baptism_id">
                    <div class="row">
                        <!-- Catechumen Information -->
                        <div class="col-md-4">
                            <h5>Catechumen Information</h5>
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="catechumen_fname" id="edit_catechumen_fname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <input type="text" name="catechumen_mname" id="edit_catechumen_mname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="catechumen_lname" id="edit_catechumen_lname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Date of Birth</label>
                                <input type="date" name="date_of_birth" id="edit_date_of_birth" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Place of Birth</label>
                                <input type="text" name="place_of_birth" id="edit_place_of_birth" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Nationality</label>
                                <input type="text" name="nationality" id="edit_nationality" class="form-control">
                            </div>
                        </div>

                        <!-- Father's Information -->
                        <div class="col-md-4">
                            <h5>Father's Information</h5>
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="father_fname" id="edit_father_fname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <input type="text" name="father_mname" id="edit_father_mname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="father_lname" id="edit_father_lname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Place of Birth</label>
                                <input type="text" name="father_placeofbirth" id="edit_father_placeofbirth" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="father_address" id="edit_father_address" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Civil Status</label>
                                <input type="text" name="father_civilstatus" id="edit_father_civilstatus" class="form-control">
                            </div>
                        </div>

                        <!-- Mother's Information -->
                        <div class="col-md-4">
                            <h5>Mother's Information</h5>
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" name="mother_fname" id="edit_mother_fname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <input type="text" name="mother_mname" id="edit_mother_mname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" name="mother_lname" id="edit_mother_lname" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Place of Birth</label>
                                <input type="text" name="mother_placeofbirth" id="edit_mother_placeofbirth" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Address</label>
                                <input type="text" name="mother_address" id="edit_mother_address" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Civil Status</label>
                                <input type="text" name="mother_civilstatus" id="edit_mother_civilstatus" class="form-control">
                            </div>
                        </div>

                        <!-- Sponsors Information -->
                        <div class="col-md-6 mt-3">
                            <h5>Sponsors Information</h5>
                            <div class="mb-3">
                                <label>Primary Sponsor (Male)</label>
                                <input type="text" name="p_sponsor_male" id="edit_p_sponsor_male" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Primary Sponsor (Female)</label>
                                <input type="text" name="p_sponsor_female" id="edit_p_sponsor_female" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 3</label>
                                <input type="text" name="sponsor_three" id="edit_sponsor_three" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 4</label>
                                <input type="text" name="sponsor_four" id="edit_sponsor_four" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 5</label>
                                <input type="text" name="sponsor_five" id="edit_sponsor_five" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 6</label>
                                <input type="text" name="sponsor_six" id="edit_sponsor_six" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 7</label>
                                <input type="text" name="sponsor_seven" id="edit_sponsor_seven" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Additional Sponsor 8</label>
                                <input type="text" name="sponsor_eight" id="edit_sponsor_eight" class="form-control">
                            </div>
                        </div>

                        <!-- Baptism Details -->
                        <div class="col-md-6 mt-3">
                            <h5>Baptism Details</h5>
                            <div class="mb-3">
                                <label>Date & Time</label>
                                <input type="datetime-local" name="date_time" id="edit_date_time" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Place of Baptism</label>
                                <input type="text" name="place_of_baptism" id="edit_place_of_baptism" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Priest</label>
                                <input type="text" name="priest" id="edit_priest" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Contact No</label>
                                <input type="text" name="contact_no" id="edit_contact_no" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Schedule Type</label>
                                <input type="text" name="sched_type" id="edit_sched_type" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Reserved By</label>
                                <input type="text" name="reserver_name" id="edit_reserver_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Baptismal Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this baptismal record?</p>
                <p>This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts section -->
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#baptismalTable').DataTable();

        // View Baptismal Details
        $(document).on('click', '.view-baptismal', function() {
            var id = $(this).data('id');
            console.log("Viewing baptismal record ID: " + id); // Debug line
            
            $.ajax({
                url: 'get_baptismal_details.php',
                type: 'POST',
                data: {
                    baptism_record_id: id
                },
                success: function(response) {
                    $('#viewDetailsContent').html(response);
                    $('#viewDetailsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + "\nError: " + error);
                    alert("Error loading details. Please try again.");
                }
            });
        });

        // Edit Baptismal
        $(document).on('click', '.edit-baptismal', function() {
            var id = $(this).data('id');
            console.log("Editing baptismal record ID: " + id);
            
            $.ajax({
                url: 'view_baptismal.php',
                type: 'POST',
                data: {
                    baptism_record_id: id,
                    action: 'edit'
                },
                dataType: 'json',
                success: function(data) {
                    try {
                        console.log("Received data:", data);
                        
                        // Catechumen Information
                        $('#edit_baptism_id').val(data.baptism_record_id);
                        $('#edit_catechumen_fname').val(data.catechumen_fname);
                        $('#edit_catechumen_mname').val(data.catechumen_mname);
                        $('#edit_catechumen_lname').val(data.catechumen_lname);
                        $('#edit_date_of_birth').val(data.date_of_birth);
                        $('#edit_place_of_birth').val(data.place_of_birth);
                        $('#edit_nationality').val(data.nationality);

                        // Father's Information
                        $('#edit_father_fname').val(data.father_fname);
                        $('#edit_father_mname').val(data.father_mname);
                        $('#edit_father_lname').val(data.father_lname);
                        $('#edit_father_placeofbirth').val(data.father_placeofbirth);
                        $('#edit_father_address').val(data.father_address);
                        $('#edit_father_civilstatus').val(data.father_civilstatus);

                        // Mother's Information
                        $('#edit_mother_fname').val(data.mother_fname);
                        $('#edit_mother_mname').val(data.mother_mname);
                        $('#edit_mother_lname').val(data.mother_lname);
                        $('#edit_mother_placeofbirth').val(data.mother_placeofbirth);
                        $('#edit_mother_address').val(data.mother_address);
                        $('#edit_mother_civilstatus').val(data.mother_civilstatus);

                        // Sponsors Information
                        $('#edit_p_sponsor_male').val(data.p_sponsor_male);
                        $('#edit_p_sponsor_female').val(data.p_sponsor_female);
                        $('#edit_sponsor_three').val(data.sponsor_three);
                        $('#edit_sponsor_four').val(data.sponsor_four);
                        $('#edit_sponsor_five').val(data.sponsor_five);
                        $('#edit_sponsor_six').val(data.sponsor_six);
                        $('#edit_sponsor_seven').val(data.sponsor_seven);
                        $('#edit_sponsor_eight').val(data.sponsor_eight);

                        // Baptism Details - Fix the date/time conversion
                        if (data.date_time) {
                            // Convert the MySQL datetime to a format that datetime-local input can understand
                            var dateTime = data.date_time.replace(' ', 'T');
                            $('#edit_date_time').val(dateTime);
                        }
                        
                        $('#edit_place_of_baptism').val(data.place_of_baptism);
                        $('#edit_priest').val(data.priest);
                        $('#edit_email').val(data.email);
                        $('#edit_contact_no').val(data.contact_no);
                        $('#edit_sched_type').val(data.sched_type);
                        $('#edit_reserver_name').val(data.reserver_name);

                        // Show the modal
                        $('#editBaptismalModal').modal('show');
                    } catch (e) {
                        console.error('Error:', e);
                        alert('Error loading baptismal details: ' + e.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.error("Status:", status);
                    console.error("Response:", xhr.responseText);
                    alert('Error loading baptismal details. Status: ' + status);
                }
            });
        });

        // Update form submission
        $('#editBaptismalForm').submit(function(e) {
            e.preventDefault();
            console.log("Form data:", $(this).serialize()); // Debug line
            
            $.ajax({
                url: 'update_baptismal.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log("Update response:", response); // Debug line
                    if(response === 'success') {
                        $('#editBaptismalModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error updating record');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Update error:", error);
                    alert('Error updating record');
                }
            });
        });

        // Delete button with event delegation
        var deleteId;
        $('#baptismalTable').on('click', '.delete-baptismal', function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            $.ajax({
                url: 'delete_baptismal.php',
                type: 'POST',
                data: {id: deleteId},
                success: function(response) {
                    $('#deleteModal').modal('hide');
                    location.reload();
                }
            });
        });
    });
</script>

<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

