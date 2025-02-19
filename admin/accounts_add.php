<?php
include ('includes/footer.php');
?>

.modal-xl {
    max-width: 90%;
}

.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}

/* For better form layout inside modal */
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
?>

<div>
    <div class="row">
        <div class="col-md-12" >
            <div class="card" >
                <div class="card-header" >
                    <h4>Add Users
                        <a a href="javascript:void(0);" onclick="goBack()" class="btn btn-danger float-end">BACK</a>
                    </h4>

                </div>
                <div class="card-body">

                        <form action="code.php" method="POST" >
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="first_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Surname</label>
                                    <input type="text" name="surname" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Suffix</label>
                                    <input type="text" name="suffix" class="form-control">
                                </div>
                                <label for="">Sex</label>
                                <div class="col-md-6 mb-3">
                                    <label for="">Male</label>
                                    <input type="checkbox" name="sex" value="0" width="70px" height="70px" />
                                    <label for="">Female</label>
                                    <input type="checkbox" name="sex" value="1" width="70px" height="70px" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="text" name="email" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Phone</label>
                                    <input type="text" name="mobile_no" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Parish</label>
                                    <select name="parish" required class="form-control">
                                        <option value="">--Select Parish--</option>
                                        <option value="0">parish 1</option>
                                        <option value="1">parish 2</option>
                                        <option value="2">parish 3</option>
                                        <option value="3">parish 4</option>
                                        <option value="4">parish 5</option>
                                        <option value="5">parish 6</option>
                                    </select>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Region *</label>
                                    <select name="region" class="form-control form-control-md" id="region"></select>
                                    <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Province *</label>
                                    <select name="province" class="form-control form-control-md" id="province"></select>
                                    <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">City / Municipality *</label>
                                    <select name="city" class="form-control form-control-md" id="city"></select>
                                    <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <label class="form-label">Barangay *</label>
                                    <select name="barangay" class="form-control form-control-md" id="barangay"></select>
                                    <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="street-text" class="form-label">Street (Optional)</label>
                                    <input type="text" class="form-control form-control-md" name="street_text" id="street-text">
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label">Zip Code*</label>
                                    <input required type="text" class="form-control" name="zip" placeholder="Enter Zip Code">
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Role</label>
                                    <select name="role" required class="form-control">
                                        <option value="">--Select Role--</option>
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Parish</option>
                                        <option value="3">Oeconomous</option>
                                        <option value="4">Chancery</option>
                                        <option value="5">VGB</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb3">
                                    <label for="">Status</label>
                                    <input type="checkbox" name="status" width="70px" height="70px" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" name="add_user" class="btn btn-primary">Add Admin User</button>
                                </div>
                            </div>
                        </form>
                
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function goBack() {
    window.history.back();
}
</script>
