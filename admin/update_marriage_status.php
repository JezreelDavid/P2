<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['marriage_id']) && isset($_POST['status'])) {
    $id = mysqli_real_escape_string($con, $_POST['marriage_id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);

    $query = "UPDATE matrimony SET status = '$status', remarks = '$remarks' WHERE id = '$id'";
    $result = mysqli_query($con, $query);

    if($result) {
        echo "success";
    } else {
        echo "error";
    }
}
?> 