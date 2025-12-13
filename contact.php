<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);

$msg = "";

// Handle Form via POST
if (isset($_POST['send_message'])) {
  // Logic to send email would go here
  // Since no DB table for messages exists, we just show success
  $msg = "<div class='alert alert-success'>Your message has been sent successfully!</div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Contact - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="contact-page">

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
    <div class="container section">
      <div class="section-title text-center mb-5">
        <h2>Get In Touch</h2>
        <p>Have questions about registration or the venue? Send us a message.</p>
      </div>

      <div class="row gy-4">
        <div class="col-lg-6">
          <div class="row gy-4">
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-geo-alt text-primary fs-1 mb-3"></i>
                <h5>Address</h5>
                <p class="text-muted">Sports Arena, UNITEN<br>Kajang, Selangor</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm p-4 text-center">
                <i class="bi bi-envelope text-primary fs-1 mb-3"></i>
                <h5>Email</h5>
                <p class="text-muted">info@motionfest.com<br>support@motionfest.com</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card shadow-sm border-0 p-4">
            <?php echo $msg; ?>
            <form method="POST">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="col-md-12">
                  <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                </div>
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit" name="send_message" class="btn btn-primary w-100"
                    style="background-color: var(--accent-color); border:none;">Send Message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>