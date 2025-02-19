<?php
include('authentication.php');
include('includes/header.php');
?>

<div>
    <h4 class="mt-4">Users</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active" >Dashboard</li>
        <li class="breadcrumb-item">Users</li>
    </ol>
    <div class="row">
        <div class="col-md-12" >
            <div class="card" >
                <div class="card-header" >
                    <h4>Edit User</h4>

                    <h4>Add Users
                        <a a href="javascript:void(0);" onclick="goBack()" class="btn btn-danger float-end">BACK</a>
                    </h4>

                </div>
                <div class="card-body">

                <?php
                if(isset($_GET['id']))
                {
                    $user_id = $_GET['id'];
                    $users = "SELECT * FROM users WHERE id='$user_id' ";
                    $users_run = mysqli_query($con, $users);

                    if(mysqli_num_rows($users_run) > 0)
                    {
                        foreach($users_run as $user)
                        {
                        ?>

                        <form action="code.php" method="POST" >
                            <input type="hidden" name="user_id" value="<?= $user['id'];?>" >
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="">First Name</label>
                                    <input type="text" name="first_name" value="<?= $user['first_name'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Middle Name</label>
                                    <input type="text" name="middle_name" value="<?= $user['middle_name'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Surname</label>
                                    <input type="text" name="surname" value="<?= $user['surname'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Suffix</label>
                                    <input type="text" name="suffix" value="<?= $user['suffix'];?>" class="form-control">
                                </div>
                                <label for="">Sex</label>
                                <div class="col-md-6 mb-3">
                                    <label for="">Male</label>
                                    <input type="checkbox" name="sex" value="0" <?= $user['sex'] == '0' ? 'selected': ''?> width="70px" height="70px" />
                                    <label for="">Female</label>
                                    <input type="checkbox" name="sex" value="1" <?= $user['sex'] == '1' ? 'selected': ''?> width="70px" height="70px" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="">Username</label>
                                    <input type="text" name="username" value="<?= $user['username'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Email</label>
                                    <input type="text" name="email" value="<?= $user['email'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Phone</label>
                                    <input type="text" name="mobile_no" value="<?= $user['mobile_no'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Parish</label>
                                    <select name="parish" required class="form-control">
                                        <option value="">--Select Parish--</option>
                                        <option value="0" <?= $user['parish'] == '0' ? 'selected': ''?> >parish 1</option>
                                        <option value="1" <?= $user['parish'] == '1' ? 'selected': ''?> >parish 2</option>
                                        <option value="2" <?= $user['parish'] == '2' ? 'selected': ''?> >parish 3</option>
                                        <option value="3" <?= $user['parish'] == '3' ? 'selected': ''?> >parish 4</option>
                                        <option value="4" <?= $user['parish'] == '4' ? 'selected': ''?> >parish 5</option>
                                        <option value="5" <?= $user['parish'] == '5' ? 'selected': ''?> >parish 6</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Address</label>
                                    <input type="text" name="address" value="<?= $user['address'];?>" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Password</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Role</label>
                                    <select name="role" required class="form-control">
                                        <option value="">--Select Role--</option>
                                        <option value="0" <?= $user['role'] == '0' ? 'selected': ''?> >User</option>
                                        <option value="1" <?= $user['role'] == '1' ? 'selected': ''?> >Admin</option>
                                        <option value="2" <?= $user['role'] == '2' ? 'selected': ''?> >Parish</option>
                                        <option value="3" <?= $user['role'] == '3' ? 'selected': ''?> >Oeconomous</option>
                                        <option value="4" <?= $user['role'] == '4' ? 'selected': ''?> >Chancery</option>
                                        <option value="5" <?= $user['role'] == '5' ? 'selected': ''?> >VGB</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb3">
                                    <label for="">Status</label>
                                    <input type="checkbox" name="status" <?= $user['status'] == '1' ? 'selected': ''?> width="70px" height="70px" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
                                </div>
                            </div>
                        </form>
                    <?php
                        }
                    }
                    else
                    {
                    ?>
                    <h4>No Record Found</h4>
                    <?php
                    }
                }
                ?>

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

<?php
include ('includes/footer.php');
?>