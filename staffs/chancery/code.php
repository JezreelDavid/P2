<?php
include('authentication.php');
//Delete for Client
if(isset($_POST['user_delete']))
{
    $user_id = $_POST['user_delete'];

    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header('Location: view_register.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: view_register.php');
        exit(0);
    }
}

//add client
if(isset($_POST['add_user']))
{
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $suffix = $_POST['suffix'];
    $sex = $_POST['sex'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $parish = $_POST['parish'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $status = $_POST['status'] == true ? '1':'0';

    $query = "INSERT INTO users (first_name,middle_name,surname,suffix,sex,username,email,mobile_no,parish,address,role,password,status) VALUES ('$first_name','$middle_name','$surname','$suffix','$sex','$username','$email','$mobile_no','$parish','$address','$role','$password','$status')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Admin/User Added Successfully";
        header('Location: view_register.php');
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: view_register.php');
        exit(0);
    }
}


//update client
if(isset($_POST['update_user']))
{
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $surname = $_POST['surname'];
    $suffix = $_POST['suffix'];
    $sex = $_POST['sex'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile_no = $_POST['mobile_no'];
    $parish = $_POST['parish'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $status = $_POST['status'] == true ? '1':'0';

    $query = "UPDATE users SET first_name='$first_name', middle_name='$middle_name', surname='$surname', suffix='$suffix', sex='$sex', username='$username', email='$email', mobile_no='$mobile_no', parish='$parish', address='$address', role='$role', password='$password', status='$status'
                WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Update Successfully";
        header('Location: view_register.php');
        exit(0);
    }
}

?>