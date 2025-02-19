<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['id'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    
    $query = "DELETE FROM burial WHERE burial_record_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Burial record deleted successfully";
        echo "success";
    } else {
        echo "error";
    }
    mysqli_stmt_close($stmt);
}
?> 