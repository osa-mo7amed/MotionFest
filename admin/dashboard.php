<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check Admin Access
if (!isset($_SESSION['admin_id'])) {
  header("Location: ../login.php");
  exit();
}

// 1. Fetch Basic Metrics
$u_res = mysqli_query($conn, "SELECT COUNT(*) FROM users");
$u_count = mysqli_fetch_row($u_res)[0];

$e_res = mysqli_query($conn, "SELECT COUNT(*) FROM events");
$e_count = mysqli_fetch_row($e_res)[0];

$p_res = mysqli_query($conn, "SELECT COUNT(*) FROM participants");
$p_count = mysqli_fetch_row($p_res)[0];

$feed_res = mysqli_query($conn, "SELECT * FROM feedbacks ORDER BY feedbackID DESC LIMIT 5");

// 2. Fetch Recent Registrations (Last 5)
$recent_sql = "SELECT u.firstName, u.lastName, e.eventName, e.eventType 
               FROM participants p 
               JOIN users u ON p.userID = u.userID 
               JOIN events e ON p.eventID = e.eventID 
               ORDER BY p.participantID DESC LIMIT 5";
$recent_res = mysqli_query($conn, $recent_sql);

// 3. Fetch Event Capacity Status (For Progress Bars)
$cap_sql = "SELECT eventName, maxParticipants, eventID FROM events LIMIT 5";
$cap_res = mysqli_query($conn, $cap_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin Dashboard - MotionFest</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/css/main.css" rel="stylesheet">
  <style>
    .card-icon {
      font-size: 2.5rem;
      opacity: 0.3;
      position: absolute;
      right: 20px;
      top: 20px;
    }

    .stat-card {
      position: relative;
      overflow: hidden;
      transition: transform 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>

<body>
  <header id="header" class="header d-flex align-items-center fixed-top bg-white shadow-sm">
    <div class="container-fluid container-xl d-flex justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <h1 class="sitename text-dark">MotionFest <span style="font-size:0.6em; color:var(--accent-color);">ADMIN</span>
        </h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="dashboard.php" class="active">Dashboard</a></li>
          <li><a href="events.php" class="active">Events</a></li>
          <li><a href="participants.php" class="active">Participants</a></li>
          <li><a href="../logout.php" class="text-danger">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main mt-5 pt-5">
    <div class="container section">

      <div class="row mb-4">
        <div class="col-12">
          <h3>Welcome back, <?php echo $_SESSION['name']; ?>!</h3>
          <p class="text-muted">Here is what is happening at MotionFest today.</p>
        </div>
      </div>

      <div class="row gy-4 mb-5">
        <div class="col-xl-4 col-md-6">
          <div class="card stat-card bg-primary text-white h-100 border-0 shadow">
            <div class="card-body">
              <i class="bi bi-people-fill card-icon"></i>
              <h6 class="text-uppercase mb-2">Registered Users</h6>
              <h2 class="mb-0 fw-bold"><?php echo $u_count; ?></h2>
              <small>Athletes in the system</small>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card stat-card bg-success text-white h-100 border-0 shadow">
            <div class="card-body">
              <i class="bi bi-trophy-fill card-icon"></i>
              <h6 class="text-uppercase mb-2">Active Events</h6>
              <h2 class="mb-0 fw-bold"><?php echo $e_count; ?></h2>
              <small>Scheduled tournaments</small>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-md-6">
          <div class="card stat-card bg-warning text-dark h-100 border-0 shadow">
            <div class="card-body">
              <i class="bi bi-ticket-perforated-fill card-icon"></i>
              <h6 class="text-uppercase mb-2">Total Participations</h6>
              <h2 class="mb-0 fw-bold"><?php echo $p_count; ?></h2>
              <small>Seats filled across all events</small>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-7 mb-4">
          <div class="card shadow-sm h-100">
            <div
              class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Recent Registrations</h5>
              <a href="participants.php" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover align-middle">
                  <thead class="table-light">
                    <tr>
                      <th>Participant</th>
                      <th>Event</th>
                      <th>Category</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (mysqli_num_rows($recent_res) > 0) {
                      while ($row = mysqli_fetch_assoc($recent_res)) {
                        echo "<tr>
                                <td class='fw-bold'>{$row['firstName']} {$row['lastName']}</td>
                                <td>{$row['eventName']}</td>
                                <td><span class='badge bg-secondary'>{$row['eventType']}</span></td>
                            </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='3' class='text-center text-muted'>No recent activity.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 mb-4">

          <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
              <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body d-grid gap-2">
              <a href="events.php" class="btn btn-outline-success text-start">
                <i class="bi bi-plus-circle-fill me-2"></i> Create New Event
              </a>
              <a href="participants.php" class="btn btn-outline-primary text-start">
                <i class="bi bi-search me-2"></i> Search for Participant
              </a>
            </div>
          </div>

          <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3">
              <h5 class="mb-0">Event Capacity Monitor</h5>
              <small class="text-muted">Top 5 Events Status</small>
            </div>
            <div class="card-body">
              <?php
              while ($ev = mysqli_fetch_assoc($cap_res)) {
                $eid = $ev['eventID'];
                $c_res = mysqli_query($conn, "SELECT COUNT(*) as c FROM participants WHERE eventID=$eid");
                $curr = mysqli_fetch_assoc($c_res)['c'];
                $max = $ev['maxParticipants'];

                // Prevent division by zero
                $percent = ($max > 0) ? round(($curr / $max) * 100) : 0;

                // Color logic
                $color = "bg-success";
                if ($percent > 50)
                  $color = "bg-warning";
                if ($percent > 85)
                  $color = "bg-danger";
                ?>
                <div class="mb-3">
                  <div class="d-flex justify-content-between mb-1">
                    <span class="fw-bold small"><?php echo $ev['eventName']; ?></span>
                    <span class="small"><?php echo "$curr / $max"; ?></span>
                  </div>
                  <div class="progress" style="height: 8px;">
                    <div class="progress-bar <?php echo $color; ?>" role="progressbar"
                      style="width: <?php echo $percent; ?>%"></div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>

        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card shadow-sm border-0">
            <div
              class="card-header bg-white border-bottom-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
              <h5 class="mb-0">User Feedbacks</h5>
              <a href="feedback.php" class="btn btn-sm btn-outline-info">View All Messages</a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>ID</th>
                      <th>Sender</th>
                      <th>Email</th>
                      <th>Subject</th>
                      <th>Preview</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (mysqli_num_rows($feed_res) > 0) {
                      while ($row = mysqli_fetch_assoc($feed_res)) {
                        // Truncate message for preview
                        $preview = (strlen($row['message']) > 50) ? substr($row['message'], 0, 50) . '...' : $row['message'];
                        echo "<tr>
                                <td>#{$row['feedbackID']}</td>
                                <td class='fw-bold'>{$row['fullName']}</td>
                                <td>{$row['email']}</td>
                                <td><span class='badge bg-light text-dark border'>{$row['subject']}</span></td>
                                <td class='text-muted small'>{$preview}</td>
                            </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5' class='text-center text-muted py-4'>No feedbacks received yet.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>


  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>