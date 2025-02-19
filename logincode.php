<?php
session_start();
include('admin/config/dbcon.php');


if(isset($_POST['login_btn']))
{
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // First, fetch user by email only
    $login_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $login_query_run = mysqli_query($con, $login_query);

    if(mysqli_num_rows($login_query_run) > 0)
    {
        $data = mysqli_fetch_array($login_query_run);
        // Verify the password hash
        if(password_verify($password, $data['password']))
        {
            // Password is correct, set up the session
            $user_id = $data['id'];
            $user_name = $data['first_name'].' '.$data['middle_name'].' '.$data['surname'].' '.$data['suffix'];
            $user_email = $data['email'];
            $role = $data['role'];

            // Set session variables
            $_SESSION['auth'] = true;
            $_SESSION['auth_role'] = $role; // role is a string like 'user', 'admin', etc.
            $_SESSION['auth_user'] = [
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_email' => $user_email,
            ];

            // Redirect based on role
            switch($role) {
                case '0': // User
                    $_SESSION['message'] = "You are Logged In";
                    header("Location: main.php");
                    break;
                case '1': // Admin
                    $_SESSION['message'] = "Welcome to Admin Dashboard";
                    header("Location: admin/admin.php");
                    break;
                case '2':
                    $_SESSION['message'] = "Welcome to Parish Dashboard";
                    header("Location: staffs/parish/index.php");
                    break;
                case '3':
                    $_SESSION['message'] = "Welcome to Oeconomous Dashboard";
                    header("Location: staffs/oeconomous/index.php");
                    break;
                case '4':
                    $_SESSION['message'] = "Welcome to Chancery Dashboard";
                    header("Location: staffs/chancery/index.php");
                    break;
                case '5':
                    $_SESSION['message'] = "Welcome to VGM Dashboard";
                    header("Location: staffs/vgm/index.php");
                    break;
                default:
                    $_SESSION['message'] = "Role not recognized!";
                    header("Location: login.php");
                    break;
            }
            exit(0);
        }
        else
        {
            // If the password is incorrect
            $_SESSION['message'] = "Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    }
    else
    {
        // If no matching user is found
        $_SESSION['message'] = "Invalid Email or Password";
        header("Location: login.php");
        exit(0);
    }
}
else
{
    // If the login button was not clicked
    $_SESSION['message'] = "You are not allowed to access this file";
    header("Location: login.php");
    exit(0);
}

?>
