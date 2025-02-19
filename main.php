<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Menu</title>

  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  <link rel="stylesheet" href="assets/CSS/style4sidebar.css" />
    <style>
    .logout-btn {
      background: none;
      border: none;
      color: inherit;
      font: inherit;
      cursor: pointer;
      padding: 0;
      display: flex;
      align-items: center;
      width: 100%;
      text-align: left;
    }
  </style>
</head>

<body>
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="assets/img/v42_64.png" alt="logo" />
      <h2>Pasiginae</h2>
    </div>

    <ul class="sidebar-links">
      <h4>
        <span>Main Menu</span>
        <div class="menu-separator"></div>
      </h4>
      <li>
        <a href="#">
          <span class="material-symbols-outlined"> dashboard </span>Dashboard</a>
      </li>
      <li>
      <h4>
        <span>General</span>
        <div class="menu-separator"></div>
      </h4>
      <li>
        <a href="calend.php"><span class="material-symbols-outlined"> dataset </span>Calendar</a>
      </li>
      <li>
        <a href="card2certificate.html"><span class="material-symbols-outlined"> quick_reference</span>Certificates</a>
      </li>
      <li>
        <a href="card.html"><span class="material-symbols-outlined"> settings_accessibility </span>Events</a>
      </li>
     
      <h4>
        <span>Account</span>
        <div class="menu-separator"></div>
      </h4>

      <li>
        <a href="#"><span class="material-symbols-outlined">
            notifications_active </span>Notifications</a>
      </li>

      <li>
        <a href="userprofile.html"><span class="material-symbols-outlined"> account_circle </span>Profile</a>
      </li>

      <li>
        <a href="startapp.php"><span class="material-symbols-outlined"> email  </span>Chat</a>
      </li>

      <li>
        <form action="allcode.php" method="POST">
          <button type="submit" name="logout_btn" class="logout-btn">
            <a><span class="material-symbols-outlined">logout</span>Logout</a>
          </button>
        </form>
      </li>
    </ul>
    </div>
  </aside>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/CSS/style4card.css">
</head>
<body>
    <div class="card-list">
        <a href="SeventhPage.html" class="card-item">
            <img src="assets/img/BOARD OF CLERGGY.jpg" alt="Card Image">
            <span class="developer">Clergy</span>
            <h3>Get to know the clergy of Pasig!</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>

        <a href="ThirdPage.html" class="card-item">
            <img src="assets/img/v42_64.png" alt="Card Image">
            <span class="designer">The Bishop</span>
            <h3>Know the two amazing Bishops of Pasig</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
        <a href="SecondPage.html" class="card-item">
            <img src="assets/img/v42_62.png" alt="Card Image">
            <span class="editor">The Diocese</span>
            <h3>Know the History of The Diocese of Pasig</h3>
            <div class="arrow">
                <i class="fas fa-arrow-right card-icon"></i>
            </div>
        </a>
    </div>
</body>
</html>