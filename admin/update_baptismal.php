<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['baptism_id'])) {
    $id = mysqli_real_escape_string($con, $_POST['baptism_id']);
    
    // Sanitize all inputs
    $catechumen_fname = mysqli_real_escape_string($con, $_POST['catechumen_fname']);
    $catechumen_mname = mysqli_real_escape_string($con, $_POST['catechumen_mname']);
    $catechumen_lname = mysqli_real_escape_string($con, $_POST['catechumen_lname']);
    $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
    $place_of_birth = mysqli_real_escape_string($con, $_POST['place_of_birth']);
    $nationality = mysqli_real_escape_string($con, $_POST['nationality']);
    $date_time = mysqli_real_escape_string($con, $_POST['date_time']);
    $place_of_baptism = mysqli_real_escape_string($con, $_POST['place_of_baptism']);
    $priest = mysqli_real_escape_string($con, $_POST['priest']);
    $sched_type = mysqli_real_escape_string($con, $_POST['sched_type']);
    $reserver_name = mysqli_real_escape_string($con, $_POST['reserver_name']);
    
    // New fields
    $fathers_name = mysqli_real_escape_string($con, $_POST['fathers_name']);
    $fathers_birthplace = mysqli_real_escape_string($con, $_POST['fathers_birthplace']);
    $mothers_name = mysqli_real_escape_string($con, $_POST['mothers_name']);
    $mothers_birthplace = mysqli_real_escape_string($con, $_POST['mothers_birthplace']);
    $godfathers_name = mysqli_real_escape_string($con, $_POST['godfathers_name']);
    $godmothers_name = mysqli_real_escape_string($con, $_POST['godmothers_name']);

    $query = "UPDATE baptism SET 
        catechumen_fname = '$catechumen_fname',
        catechumen_mname = '$catechumen_mname',
        catechumen_lname = '$catechumen_lname',
        date_of_birth = '$date_of_birth',
        place_of_birth = '$place_of_birth',
        nationality = '$nationality',
        date_time = '$date_time',
        place_of_baptism = '$place_of_baptism',
        priest = '$priest',
        sched_type = '$sched_type',
        reserver_name = '$reserver_name',
        fathers_name = '$fathers_name',
        fathers_birthplace = '$fathers_birthplace',
        mothers_name = '$mothers_name',
        mothers_birthplace = '$mothers_birthplace',
        godfathers_name = '$godfathers_name',
        godmothers_name = '$godmothers_name'
        WHERE baptism_record_id = '$id'";

    $query_run = mysqli_query($con, $query);

    if($query_run) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?> 