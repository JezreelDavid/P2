<?php
include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Users</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?php include('message.php'); ?>
            <div class="card">
                <div class="card-header">
                    <h4>Register User</h4>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        Add User
                    </button>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="role" class="form-select">
                                    <option value="">All Roles</option>
                                    <option value="0" <?= isset($_GET['role']) && $_GET['role'] === '0' ? 'selected' : '' ?>>User</option>
                                    <option value="1" <?= isset($_GET['role']) && $_GET['role'] === '1' ? 'selected' : '' ?>>Admin</option>
                                    <option value="2" <?= isset($_GET['role']) && $_GET['role'] === '2' ? 'selected' : '' ?>>Parish</option>
                                    <option value="3" <?= isset($_GET['role']) && $_GET['role'] === '3' ? 'selected' : '' ?>>Oeconomous</option>
                                    <option value="4" <?= isset($_GET['role']) && $_GET['role'] === '4' ? 'selected' : '' ?>>Chancery</option>
                                    <option value="5" <?= isset($_GET['role']) && $_GET['role'] === '5' ? 'selected' : '' ?>>VGM</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by name or email" 
                                       value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="myDataTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Parish</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM users WHERE 1 = 1";
                                if(isset($_GET['role']) && $_GET['role'] !== '') {
                                    $role = mysqli_real_escape_string($con, $_GET['role']);
                                    $query .= " AND role = '$role'";
                                }

                                if(isset($_GET['search']) && $_GET['search'] !== '') {
                                    $search = mysqli_real_escape_string($con, $_GET['search']);
                                    $query .= " AND (first_name LIKE '%$search%' OR middle_name LIKE '%$search%' 
                                              OR surname LIKE '%$search%' OR email LIKE '%$search%')";
                                }

                                $query_run = mysqli_query($con, $query);

                                if(mysqli_num_rows($query_run) > 0) {
                                    foreach($query_run as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row['id'] ?></td>
                                            <td>
                                                <?= htmlspecialchars($row['surname'] . ", " . $row['first_name'] . " " . $row['middle_name']) ?>
                                                <?= $row['suffix'] ? "(" . htmlspecialchars($row['suffix']) . ")" : '' ?>
                                                <br>
                                                <small class="text-muted"><?= $row['sex'] == '0' ? 'Male' : 'Female' ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($row['username']) ?></td>
                                            <td><?= htmlspecialchars($row['email']) ?></td>
                                            <td><?= htmlspecialchars($row['mobile_no']) ?></td>
                                            <td><?= $row['parish'] == '0' ? 'Parish 1' : ($row['parish'] == '1' ? 'Parish 2' : 'Other') ?></td>
                                            <td>
                                                <?= htmlspecialchars($row['street_text'] . ', ' . 
                                                    $row['barangay_text'] . ', ' . 
                                                    $row['city_text'] . ', ' . 
                                                    $row['province_text'] . ', ' . 
                                                    $row['region_text'] . ' ' . 
                                                    $row['zip']) ?>
                                            </td>
                                            <td>
                                                <?php
                                                switch($row['role']) {
                                                    case '0': echo 'User'; break;
                                                    case '1': echo 'Admin'; break;
                                                    case '2': echo 'Parish'; break;
                                                    case '3': echo 'Oeconomous'; break;
                                                    case '4': echo 'Chancery'; break;
                                                    case '5': echo 'VGM'; break;
                                                    default: echo 'Unknown Role';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success edit-user" 
                                                            data-id="<?= $row['id'] ?>">
                                                        Edit
                                                    </button>
                                                    <form action="code.php" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        <button type="submit" name="user_delete" value="<?= $row['id'] ?>" 
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No Record Found</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="code.php" method="POST" id="addUserForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="surname">Surname</label>
                            <input type="text" name="surname" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="suffix">Suffix</label>
                            <input type="text" name="suffix" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sex</label>
                            <div class="form-check">
                                <input type="radio" name="sex" value="0" class="form-check-input" required>
                                <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="sex" value="1" class="form-check-input">
                                <label class="form-check-label">Female</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mobile_no">Phone</label>
                            <input type="text" name="mobile_no" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="parish">Parish</label>
                            <select name="parish" class="form-control" required>
                                <option value="">--Select Parish--</option>
                                <option value="0">Parish 1</option>
                                <option value="1">Parish 2</option>
                                <option value="2">Parish 3</option>
                                <option value="3">Parish 4</option>
                                <option value="4">Parish 5</option>
                                <option value="5">Parish 6</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="region">Region</label>
                            <select name="region" class="form-control" id="region" required></select>
                            <input type="hidden" name="region_text" id="region-text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="province">Province</label>
                            <select name="province" class="form-control" id="province" required></select>
                            <input type="hidden" name="province_text" id="province-text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city">City/Municipality</label>
                            <select name="city" class="form-control" id="city" required></select>
                            <input type="hidden" name="city_text" id="city-text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="barangay">Barangay</label>
                            <select name="barangay" class="form-control" id="barangay" required></select>
                            <input type="hidden" name="barangay_text" id="barangay-text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="street_text">Street (Optional)</label>
                            <input type="text" name="street_text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip">Zip Code</label>
                            <input type="text" name="zip" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="">--Select Role--</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                                <option value="2">Parish</option>
                                <option value="3">Oeconomous</option>
                                <option value="4">Chancery</option>
                                <option value="5">VGM</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input type="checkbox" name="status" class="form-check-input">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="addUserForm" name="add_user" class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="code.php" method="POST" id="editUserForm">
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_first_name">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_middle_name">Middle Name</label>
                            <input type="text" name="middle_name" id="edit_middle_name" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_surname">Surname</label>
                            <input type="text" name="surname" id="edit_surname" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_suffix">Suffix</label>
                            <input type="text" name="suffix" id="edit_suffix" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Sex</label>
                            <div class="form-check">
                                <input type="radio" name="sex" value="0" id="edit_sex_male" class="form-check-input" required>
                                <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="sex" value="1" id="edit_sex_female" class="form-check-input">
                                <label class="form-check-label">Female</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_username">Username</label>
                            <input type="text" name="username" id="edit_username" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_email">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_mobile_no">Phone</label>
                            <input type="text" name="mobile_no" id="edit_mobile_no" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_parish">Parish</label>
                            <select name="parish" id="edit_parish" class="form-control" required>
                                <option value="">--Select Parish--</option>
                                <option value="0">Parish 1</option>
                                <option value="1">Parish 2</option>
                                <option value="2">Parish 3</option>
                                <option value="3">Parish 4</option>
                                <option value="4">Parish 5</option>
                                <option value="5">Parish 6</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_region">Region</label>
                            <select name="region" class="form-control" id="edit_region" required></select>
                            <input type="hidden" name="region_text" id="edit_region_text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_province">Province</label>
                            <select name="province" class="form-control" id="edit_province" required></select>
                            <input type="hidden" name="province_text" id="edit_province_text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_city">City/Municipality</label>
                            <select name="city" class="form-control" id="edit_city" required></select>
                            <input type="hidden" name="city_text" id="edit_city_text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_barangay">Barangay</label>
                            <select name="barangay" class="form-control" id="edit_barangay" required></select>
                            <input type="hidden" name="barangay_text" id="edit_barangay_text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_street_text">Street (Optional)</label>
                            <input type="text" name="street_text" id="edit_street_text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_zip">Zip Code</label>
                            <input type="text" name="zip" id="edit_zip" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_password">Password (Leave blank to keep current)</label>
                            <input type="password" name="password" id="edit_password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_role">Role</label>
                            <select name="role" id="edit_role" class="form-control" required>
                                <option value="">--Select Role--</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                                <option value="2">Parish</option>
                                <option value="3">Oeconomous</option>
                                <option value="4">Chancery</option>
                                <option value="5">VGM</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_status">Status</label>
                            <div class="form-check">
                                <input type="checkbox" name="status" id="edit_status" class="form-check-input">
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="editUserForm" name="update_user" class="btn btn-primary">Update User</button>
            </div>
        </div>
    </div>
</div>

<style>
.modal-xl {
    max-width: 90%;
}

.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}

.modal-body .row {
    margin-right: -10px;
    margin-left: -10px;
}

.modal-body .col-md-6,
.modal-body .col-md-12,
.modal-body .col-sm-6 {
    padding-right: 10px;
    padding-left: 10px;
}

.form-check-input[type="radio"] {
    margin-top: 0.3rem;
}

.btn-group {
    gap: 5px;
}

.modal-body.loading {
    position: relative;
    min-height: 200px;
}

.modal-body.loading:after {
    content: 'Loading...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.8);
    padding: 20px;
    border-radius: 5px;
    z-index: 1000;
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#myDataTable').DataTable({
        responsive: true
    });

    // Initialize address dropdowns when add modal opens
    $('#addUserModal').on('shown.bs.modal', function () {
        initializeAddressDropdowns();
    });

    // Clear form when add modal is closed
    $('#addUserModal').on('hidden.bs.modal', function () {
        $('#addUserForm')[0].reset();
        $('#region, #province, #city, #barangay').empty();
    });

    // Handle edit button click
    $(document).on('click', '.edit-user', function() {
        var userId = $(this).data('id');
        
        // Show loading state
        $('#editUserModal .modal-body').addClass('loading');
        
        // Fetch user data using AJAX
        $.ajax({
            url: 'code.php',
            type: 'POST',
            data: {
                'get_user_details': true,
                'user_id': userId
            },
            success: function(response) {
                try {
                    var userData = JSON.parse(response);
                    
                    // Populate form fields with user data
                    $('#edit_user_id').val(userData.id);
                    $('#edit_first_name').val(userData.first_name);
                    $('#edit_middle_name').val(userData.middle_name);
                    $('#edit_surname').val(userData.surname);
                    $('#edit_suffix').val(userData.suffix);
                    $('#edit_username').val(userData.username);
                    $('#edit_email').val(userData.email);
                    $('#edit_mobile_no').val(userData.mobile_no);
                    $('#edit_parish').val(userData.parish);
                    $('#edit_role').val(userData.role);
                    
                    // Handle sex radio buttons
                    if(userData.sex === '0') {
                        $('#edit_sex_male').prop('checked', true);
                    } else if(userData.sex === '1') {
                        $('#edit_sex_female').prop('checked', true);
                    }
                    
                    // Handle status checkbox
                    $('#edit_status').prop('checked', userData.status === '1');
                    
                    // Handle address fields
                    $('#edit_street_text').val(userData.street_text);
                    $('#edit_zip').val(userData.zip);
                    
                    // Show the modal
                    $('#editUserModal').modal('show');
                    
                } catch (e) {
                    console.error('Error parsing user data:', e);
                    alert('Error loading user data');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Error fetching user data');
            },
            complete: function() {
                // Remove loading state
                $('#editUserModal .modal-body').removeClass('loading');
            }
        });
    });

    // Initialize address dropdowns for edit form
    function initializeEditAddressDropdowns(userData) {
        // Load regions
        $.ajax({
            url: 'get_regions.php',
            type: 'GET',
            success: function(response) {
                var regions = JSON.parse(response);
                var regionSelect = $('#edit_region');
                regionSelect.empty();
                regionSelect.append(new Option('--Select Region--', ''));
                
                regions.forEach(function(region) {
                    var option = new Option(region.name, region.code);
                    regionSelect.append(option);
                });
                
                // Set selected region and load provinces
                regionSelect.val(userData.region);
                
                // Load provinces
                $.ajax({
                    url: 'get_provinces.php',
                    type: 'GET',
                    data: { region_code: userData.region },
                    success: function(response) {
                        var provinces = JSON.parse(response);
                        var provinceSelect = $('#edit_province');
                        provinceSelect.empty();
                        provinceSelect.append(new Option('--Select Province--', ''));
                        
                        provinces.forEach(function(province) {
                            var option = new Option(province.name, province.code);
                            provinceSelect.append(option);
                        });
                        
                        // Set selected province and load cities
                        provinceSelect.val(userData.province);
                        
                        // Load cities
                        $.ajax({
                            url: 'get_cities.php',
                            type: 'GET',
                            data: { province_code: userData.province },
                            success: function(response) {
                                var cities = JSON.parse(response);
                                var citySelect = $('#edit_city');
                                citySelect.empty();
                                citySelect.append(new Option('--Select City--', ''));
                                
                                cities.forEach(function(city) {
                                    var option = new Option(city.name, city.code);
                                    citySelect.append(option);
                                });
                                
                                // Set selected city and load barangays
                                citySelect.val(userData.city);
                                
                                // Load barangays
                                $.ajax({
                                    url: 'get_barangays.php',
                                    type: 'GET',
                                    data: { city_code: userData.city },
                                    success: function(response) {
                                        var barangays = JSON.parse(response);
                                        var barangaySelect = $('#edit_barangay');
                                        barangaySelect.empty();
                                        barangaySelect.append(new Option('--Select Barangay--', ''));
                                        
                                        barangays.forEach(function(barangay) {
                                            var option = new Option(barangay.name, barangay.code);
                                            barangaySelect.append(option);
                                        });
                                        
                                        // Set selected barangay
                                        barangaySelect.val(userData.barangay);
                                    }
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    // Handle address dropdown changes in edit form
    $('#edit_region').change(function() {
        loadProvinces($(this).val(), '');
        $('#edit_region_text').val($(this).find('option:selected').text());
    });

    $('#edit_province').change(function() {
        loadCities($(this).val(), '');
        $('#edit_province_text').val($(this).find('option:selected').text());
    });

    $('#edit_city').change(function() {
        loadBarangays($(this).val(), '');
        $('#edit_city_text').val($(this).find('option:selected').text());
    });

    $('#edit_barangay').change(function() {
        $('#edit_barangay_text').val($(this).find('option:selected').text());
    });
});

function initializeAddressDropdowns() {
    // Add your address dropdown initialization code here
    // This should populate the region dropdown initially
    // and set up change handlers for cascading updates
}

function loadProvinces(regionCode, selectedProvince) {
    // Add your province loading code here
}

function loadCities(provinceCode, selectedCity) {
    // Add your city loading code here
}

function loadBarangays(cityCode, selectedBarangay) {
    // Add your barangay loading code here
}

function goBack() {
    window.history.back();
}
</script>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>