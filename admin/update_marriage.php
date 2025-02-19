<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['marriage_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['marriage_id']);
    $groom_name = mysqli_real_escape_string($con, $_POST['groom_name']);
    $bride_name = mysqli_real_escape_string($con, $_POST['bride_name']);
    $date_time = mysqli_real_escape_string($con, $_POST['date_time']);
    $parish = mysqli_real_escape_string($con, $_POST['parish']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $reserver_name = mysqli_real_escape_string($con, $_POST['reserver_name']);

    $query = "UPDATE matrimony SET 
              groom_name = ?, 
              bride_name = ?, 
              date_time = ?, 
              parish = ?, 
              status = ?, 
              reserver_name = ? 
              WHERE marriage_record_id = ?";
              
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", 
        $groom_name, 
        $bride_name, 
        $date_time, 
        $parish, 
        $status, 
        $reserver_name, 
        $id
    );

    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Marriage record updated successfully";
        echo "success";
    } else {
        echo "error";
    }
    mysqli_stmt_close($stmt);
}
?> 