<?php
session_start();


if(isset($_SESSION['auth']))
{
  if(!isset($_SESSION['message'])){
    $_SESSION['message'] = "You are already logged In";
  }
  header("Location: index.php");
  exit(0);
}

include "./includes/header.php";


echo "<body style='background-image:url(assets/img/pasig.png);
                  background-size: cover;
                  background-position: top center;
                  position: relative;
                  z-index: 1;'>";
?>

<?php include('message.php'); ?>

<div class="container py-5">
  <div class="mx-auto border shadow p-4" style="background-color: white; width: 400px">
    <h2 class="text-center mb-4">Login</h2>
    <hr />

    <form action="logincode.php" method="post">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input required placeholder="Enter Email Address" class="form-control" type="email" name="email">
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input required placeholder="Enter Password" class="form-control" type="password" name="password">
        <div class="mt-1">
          <a href="forgot-password.php" class="text-decoration-none small">Forgot Password?</a>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col d-grid">
          <button type="submit" name="login_btn" class="btn btn-primary">Log in</button>
        </div>
        <div class="col d-grid">
          <a href="index.html" class="btn btn-outline-primary">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php
include "./includes/footer.php";
?>
