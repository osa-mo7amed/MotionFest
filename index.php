<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

// Check login status for Navbar
$is_logged_in = isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Home - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="sitename">MotionFest</h1>
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
            <li><a href="logout.php" style="color: var(--accent-color);" class="text-danger">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="active">Login</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section dark-background">
      <div class="background-overlay"></div>
      <div class="hero-content">
        <div class="container text-center">
          <div class="col-lg-10 mx-auto">
            <h1 class="hero-title">Unleash Your Potential<br>at MotionFest 2026</h1>
            <p class="hero-subtitle">The ultimate sports day experience. Join the community, compete in tournaments, and
              make history.</p>
            <div class="cta-buttons mt-4">
              <a href="events.php" class="btn btn-primary btn-cta">View All Events</a>
              <?php if (!$is_logged_in): ?>
                <a href="register.php" class="btn btn-secondary btn-cta">Join Now</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="featured-events" class="section">
      <div class="container section-title">
        <h2>Featured Categories</h2>
        <p>A glimpse of what awaits you on the field.</p>
      </div>

      <div class="container">
        <div class="row gy-4">
          <?php
          // Fetch 3 events for preview
          $sql = "SELECT * FROM events LIMIT 3";
          $res = mysqli_query($conn, $sql);

          if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
              ?>
              <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                  <div class="card-body text-center">
                    <h4 class="card-title"><?php echo $row['eventName']; ?></h4>
                    <span class="badge bg-primary mb-3"><?php echo $row['eventType']; ?></span>
                    <p class="card-text small text-muted"><?php echo $row['eventDescription']; ?></p>
                    <a href="events.php" class="btn btn-outline-primary btn-sm mt-3">View Details</a>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            // Fallback if no events in DB
            echo '<div class="col-12 text-center"><p>No events announced yet. Stay tuned!</p></div>';
          }
          ?>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer position-relative dark-background">
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">MotionFest</strong> <span>All Rights Reserved</span></p>
    </div>
  </footer>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>