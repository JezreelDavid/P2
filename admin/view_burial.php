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
            <h4 class="mb-0">Burial Records</h4>
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
            <table id="burialTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Date of Death</th>
                        <th>Funeral Date</th>
                        <th>Parish</th>
                        <th>Reserved By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT b.*, u.email as user_email 
                              FROM burial b 
                              LEFT JOIN users u ON b.user_id = u.id 
                              ORDER BY b.funeral_date DESC";
                    $query_run = mysqli_query($con, $query);

                    if(mysqli_num_rows($query_run) > 0) {
                        foreach($query_run as $row) {
                            ?>
                            <tr>
                                <td><?= isset($row['burial_record_id']) ? $row['burial_record_id'] : 'N/A' ?></td>
                                <td><?= isset($row['full_name']) ? $row['full_name'] : 'N/A' ?></td>
                                <td><?= isset($row['age']) ? $row['age'] : 'N/A' ?></td>
                                <td><?= isset($row['date_of_death']) ? date('F j, Y', strtotime($row['date_of_death'])) : 'N/A' ?></td>
                                <td><?= isset($row['funeral_date']) ? date('F j, Y', strtotime($row['funeral_date'])) : 'N/A' ?></td>
                                <td><?= isset($row['parish']) ? $row['parish'] : 'N/A' ?></td>
                                <td><?= isset($row['reserver_name']) ? $row['reserver_name'] : 'N/A' ?></td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-primary btn-sm view-details" data-id="<?= $row['burial_record_id'] ?>">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm edit-burial" data-id="<?= $row['burial_record_id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-burial" data-id="<?= $row['burial_record_id'] ?>">
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
<div class="modal fade" id="viewDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Burial Record Details</h5>
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

<!-- Edit Burial Modal -->
<div class="modal fade" id="editBurialModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Burial Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editBurialForm">
                    <input type="hidden" name="burial_id" id="edit_burial_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Name of the Deceased</label>
                                <input type="text" name="name" id="edit_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Date of Death</label>
                                <input type="date" name="date_of_death" id="edit_date_of_death" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Date of Burial</label>
                                <input type="date" name="date_of_burial" id="edit_date_of_burial" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label>Cemetery</label>
                                <input type="text" name="cemetery" id="edit_cemetery" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Reserved By</label>
                                <input type="text" name="reserver_name" id="edit_reserver_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
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
                <h5 class="modal-title">Delete Burial Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this burial record?</p>
                <p>This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#burialTable').DataTable();

        // View Details
        $('.view-details').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_burial_details.php',
                type: 'POST',
                data: {burial_record_id: id},
                success: function(response) {
                    $('#viewDetailsContent').html(response);
                    $('#viewDetailsModal').modal('show');
                }
            });
        });

        // Edit Burial
        $('.edit-burial').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: 'get_burial_details.php',
                type: 'POST',
                data: {burial_record_id: id, action: 'edit'},
                success: function(response) {
                    try {
                        var data = JSON.parse(response);
                        $('#edit_burial_id').val(data.burial_record_id);
                        $('#edit_name').val(data.name);
                        $('#edit_date_of_death').val(data.date_of_death);
                        $('#edit_date_of_burial').val(data.date_of_burial);
                        $('#edit_cemetery').val(data.cemetery);
                        $('#edit_reserver_name').val(data.reserver_name);
                        $('#edit_email').val(data.email);
                        $('#editBurialModal').modal('show');
                    } catch(e) {
                        console.error('Error parsing JSON:', e);
                        alert('Error loading burial details');
                    }
                }
            });
        });

        // Update Burial Record
        $('#editBurialForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'update_burial.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editBurialModal').modal('hide');
                    location.reload();
                }
            });
        });

        // Delete Burial
        var deleteId;
        $('.delete-burial').click(function() {
            deleteId = $(this).data('id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').click(function() {
            $.ajax({
                url: 'delete_burial.php',
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

</body>
</html>
