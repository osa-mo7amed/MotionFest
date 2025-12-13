<?php
session_start();
// Check login status for Navbar
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>About - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="about-page">

  <header id="header" class="header d-flex align-items-center fixed-top bg-white shadow-sm">
    <div class="container-fluid container-xl d-flex justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename text-dark">MotionFest</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.php" class="active">About</a></li>
          <li><a href="events.php" class="active">Events</a></li>
          <li><a href="contact.php" class="active">Contact</a></li>
          <?php if ($is_logged_in): ?>
            <?php if (isset($_SESSION['admin_id'])): ?>
              <li><a href="admin/dashboard.php" class="active">Dashboard</a></li>
            <?php else: ?>
              <li><a href="profile.php" class="active">Profile</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="text-danger">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="active">Login</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main mt-5 pt-5">
    <div class="page-title dark-background" style="background-image: url(assets/img/showcase-5.jpg); padding: 100px 0;">
      <div class="container position-relative text-center">
        <h1>About Us</h1>
        <p>Celebrating Sportsmanship and Community.</p>
      </div>
    </div>

    <section id="about" class="about section">
      <div class="container">
        <div class="row gy-5 align-items-center">
          <div class="col-lg-6">
            <h3 class="mb-4">Our Mission</h3>
            <p class="lead">MotionFest is designed to bring together athletes from all walks of life to compete in a
              professional, fair, and exhilarating environment.</p>
            <p>Founded in 2024, we organize annual championships for Football, Basketball, Tennis, and Track & Field.
              Our goal is to promote health, teamwork, and the competitive spirit.</p>

            <ul class="list-unstyled mt-4">
              <li class="mb-2"><i class="bi bi-check-circle text-primary me-2"></i> Professional Venues</li>
              <li class="mb-2"><i class="bi bi-check-circle text-primary me-2"></i> Certified Referees</li>
              <li class="mb-2"><i class="bi bi-check-circle text-primary me-2"></i> Community Driven</li>
            </ul>
          </div>
          <div class="col-lg-6">
            <img src="assets/img/gallery-2.webp" class="img-fluid rounded shadow" alt="About MotionFest">
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer position-relative dark-background">
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">MotionFest</strong></p>
    </div>
  </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>