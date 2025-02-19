<?php
include "layout/header.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["email"])) {
    header("location: /login.php");
    exit;
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6 mx-auto border shadows p-4">
            <h2 class="text-center mb-4">Profile</h2>
            <hr />

            <div class="row mb-3">
                <div class="col-sm-4">Username</div>
                <div class="col-sm-8"><?= $_SESSION["username"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">First Name</div>
                <div class="col-sm-8"><?= $_SESSION["first_name"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Middle Name</div>
                <div class="col-sm-8"><?= $_SESSION["middle_name"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Surname</div>
                <div class="col-sm-8"><?= $_SESSION["surname"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Suffix</div>
                <div class="col-sm-8"><?= $_SESSION["suffix"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Sex</div>
                <div class="col-sm-8"><?= $_SESSION["sex"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Username</div>
                <div class="col-sm-8"><?= $_SESSION["username"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Email</div>
                <div class="col-sm-8"><?= $_SESSION["email"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Phone</div>
                <div class="col-sm-8"><?= $_SESSION["mobile_no"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Parish</div>
                <div class="col-sm-8"><?= $_SESSION["parish"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Address</div>
                <div class="col-sm-8"><?= $_SESSION["address"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Role</div>
                <div class="col-sm-8"><?= $_SESSION["role"] ?></div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">Registered at</div>
                <div class="col-sm-8"><?= $_SESSION["created_at"] ?></div>
            </div>

        </div>
    </div>
</div>

<?php
include "layout/footer.php";
?>