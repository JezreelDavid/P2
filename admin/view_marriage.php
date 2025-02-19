<?php
session_start();
include('config/dbcon.php');

// Check if user is logged in and is an admin
if(!isset($_SESSION['auth']) || $_SESSION['auth_role'] != "1") {
    header("Location: ../login.php");
    exit(0);
}

include('authentication.php');
include('includes/header.php');
?>

    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Marriage Records</h4>
            </div>
            <div class="card-body">
                <?php 
                if(isset($_SESSION['message'])) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    unset($_SESSION['message']);
                }
                ?>
                <table id="marriageTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Record ID</th>
                            <th>Groom Name</th>
                            <th>Bride Name</th>
                            <th>Date & Time</th>
                            <th>Parish</th>
                            <th>Event Type</th>
                            <th>Reserved By</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT m.marriage_record_id, 
                                         m.groom_name, 
                                         m.bride_name, 
                                         m.date_time, 
                                         m.parish,
                                         m.event_type,
                                         m.reserver_name,
                                         m.email,
                                         u.email as user_email 
                                  FROM matrimony m 
                                  LEFT JOIN users u ON m.email COLLATE utf8mb4_unicode_ci = u.email COLLATE utf8mb4_unicode_ci 
                                  ORDER BY m.date_time DESC";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0) {
                            foreach($query_run as $row) {
                                ?>
                                <tr>
                                    <td><?= isset($row['marriage_record_id']) ? $row['marriage_record_id'] : 'N/A' ?></td>
                                    <td><?= isset($row['groom_name']) ? $row['groom_name'] : 'N/A' ?></td>
                                    <td><?= isset($row['bride_name']) ? $row['bride_name'] : 'N/A' ?></td>
                                    <td><?= isset($row['date_time']) ? date('F j, Y g:i A', strtotime($row['date_time'])) : 'N/A' ?></td>
                                    <td><?= isset($row['parish']) ? $row['parish'] : 'N/A' ?></td>
                                    <td><?= isset($row['event_type']) ? $row['event_type'] : 'N/A' ?></td>
                                    <td><?= isset($row['reserver_name']) ? $row['reserver_name'] : 'N/A' ?></td>
                                    <td><?= isset($row['email']) ? $row['email'] : 'N/A' ?></td>
                                    <td class="action-buttons">
                                        <button type="button" class="btn btn-primary btn-sm view-details" data-id="<?= $row['marriage_record_id'] ?>" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm edit-marriage" data-id="<?= $row['marriage_record_id'] ?>" title="Edit Record">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-marriage" data-id="<?= $row['marriage_record_id'] ?>" title="Delete Record">
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

    <!-- Edit Marriage Modal -->
    <div class="modal fade" id="editMarriageModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Marriage Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editMarriageForm">
                        <input type="hidden" name="marriage_id" id="edit_marriage_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Groom Name</label>
                                    <input type="text" name="groom_name" id="edit_groom_name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Bride Name</label>
                                    <input type="text" name="bride_name" id="edit_bride_name" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Date & Time</label>
                                    <input type="datetime-local" name="date_time" id="edit_date_time" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Parish</label>
                                    <input type="text" name="parish" id="edit_parish" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <select name="status" id="edit_status" class="form-control">
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
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
                    <h5 class="modal-title">Delete Marriage Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this marriage record?</p>
                    <p>This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this modal for viewing details -->
    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Marriage Record Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

    <!-- Existing scripts -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#marriageTable').DataTable();

            // View Details
            $('.view-details').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_marriage_details.php',
                    type: 'POST',
                    data: {marriage_record_id: id},
                    success: function(response) {
                        $('#viewDetailsContent').html(response);
                        $('#viewDetailsModal').modal('show');
                    }
                });
            });

            // Edit Marriage
            $('.edit-marriage').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_marriage_details.php',
                    type: 'POST',
                    data: {marriage_record_id: id, action: 'edit'},
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            $('#edit_marriage_id').val(data.marriage_record_id);
                            $('#edit_groom_name').val(data.groom_name);
                            $('#edit_bride_name').val(data.bride_name);
                            $('#edit_date_time').val(data.date_time);
                            $('#edit_parish').val(data.parish);
                            $('#edit_status').val(data.status);
                            $('#edit_reserver_name').val(data.reserver_name);
                            $('#editMarriageModal').modal('show');
                        } catch(e) {
                            console.error('Error parsing JSON:', e);
                            alert('Error loading marriage details');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Error loading marriage details');
                    }
                });
            });

            // Update Marriage Record
            $('#editMarriageForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'update_marriage.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editMarriageModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Error updating record');
                    }
                });
            });

            // Delete Marriage
            var deleteId;
            $('.delete-marriage').click(function() {
                deleteId = $(this).data('id');
                $('#deleteModal').modal('show');
            });

            $('#confirmDelete').click(function() {
                $.ajax({
                    url: 'delete_marriage.php',
                    type: 'POST',
                    data: {id: deleteId},
                    success: function(response) {
                        $('#deleteModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('Error deleting record');
                    }
                });
            });
        });
    </script>
</body>
</html>
