<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/CSS/style.css" />
    <title>The Diocese Of Pasig</title>
    <link rel="icon" href="assets/img/Coat_of_arms_of_the_Diocese_of_Pasig.svg (1).png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Important -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--  Important ...dynamic dropdown link script -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  </head>
  <body>

<section id="header">
      <div class="header container">
        <div class="nav-bar">
          <div class="brand">
            <a href="index.php">
              <h1><img src="assets/img/Coat_of_arms_of_the_Diocese_of_Pasig.svg (1).png"> ROMAN CATHOLIC DIOCESAN PASIG</h1>
            </a>
          </div>
          <div class="nav-list">
            <div class="hamburger">
              <div class="bar"></div>
            </div>
            <ul>
              <li><a href="#DIOCESE" data-after="Home"></a></li>
              <li><a href="#NEWS" data-after="Service"></a></li>
              <li><a href="#SERVICES" data-after="Projects"></a></li>
              <li>
                <a href="#CERTIFICATES" data-after="About"></a>
              </li>
              <li><a href="#STORE" data-after="Contact"></a></li>
              <li><a href="#CHANCERY" data-after="Contact"></a></li>
              <?php if (isset($_SESSION['auth_user'])) : ?>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Settings
                <?= $_SESSION['auth_user']['user_name']; ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/profile.php">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="allcode.php" method="POST">
                    <button type="submit" name="logout_btn" class="dropdown-item">Logout</button>
                  </form>
                </li>
              </ul>
                <?php else : ?>

                <li class="nav-item">
                    <a href="/register.php" class="btn btn-outline-primary me-2">Register</a>
                </li>
                <li class="nav-item">
                    <a href="login.php" class="btn btn-primary">Login</a>
                </li>
            </li>
            <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </section>