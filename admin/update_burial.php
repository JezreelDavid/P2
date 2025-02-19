<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['burial_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['burial_id']);
    $full_name = mysqli_real_escape_string($con, $_POST['full_name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $date_of_death = mysqli_real_escape_string($con, $_POST['date_of_death']);
    $funeral_date = mysqli_real_escape_string($con, $_POST['funeral_date']);
    $parish = mysqli_real_escape_string($con, $_POST['parish']);
    $funeral_location = mysqli_real_escape_string($con, $_POST['funeral_location']);
    $reserver_name = mysqli_real_escape_string($con, $_POST['reserver_name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);

    $query = "UPDATE burial SET 
              full_name = ?, 
              age = ?,
              date_of_death = ?, 
              funeral_date = ?, 
              parish = ?,
              funeral_location = ?,
              reserver_name = ?,
              email = ?,
              contact_no = ?
              WHERE burial_record_id = ?";
              
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sissssssssi", 
        $full_name,
        $age,
        $date_of_death,
        $funeral_date,
        $parish,
        $funeral_location,
        $reserver_name,
        $email,
        $contact_no,
        $id
    );

    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Burial record updated successfully";
        echo "success";
    } else {
        echo "error";
    }
    mysqli_stmt_close($stmt);
}
?> 