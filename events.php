<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

// Handle Registration
if (isset($_POST['join_event_btn'])) {
  if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
  }

  $uid = $_SESSION['user_id'];
  $eid = $_POST['event_id'];

  // 1. Get Event Capacity
  $sql_event = "SELECT maxParticipants FROM events WHERE eventID = $eid";
  $res_event = mysqli_query($conn, $sql_event);
  $row_event = mysqli_fetch_assoc($res_event);

  // 2. Get Current Count
  $sql_count = "SELECT COUNT(*) as total FROM participants WHERE eventID = $eid";
  $res_count = mysqli_query($conn, $sql_count);
  $row_count = mysqli_fetch_assoc($res_count);

  if ($row_count['total'] < $row_event['maxParticipants']) {
    // 3. Insert Participation
    $sql_insert = "INSERT INTO participants (userID, eventID) VALUES ('$uid', '$eid')";
    mysqli_query($conn, $sql_insert);
    echo "<script>alert('Successfully Registered!'); window.location.href='profile.php';</script>";
  } else {
    echo "<script>alert('Sorry, this event is full.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Events - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
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
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="profile.php" class="active">My Profile</a></li>
            <li><a href="logout.php" class="text-danger" class="active">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="active">Login</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main mt-5 pt-5">
    <div class="container section">
      <h2 class="text-center mb-5">Upcoming Tournaments</h2>
      <div class="row gy-4">
        <?php
        $sql = "SELECT * FROM events";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          $eid = $row['eventID'];

          // Calculate slots
          $sql_c = "SELECT COUNT(*) as total FROM participants WHERE eventID = $eid";
          $res_c = mysqli_query($conn, $sql_c);
          $data_c = mysqli_fetch_assoc($res_c);
          $current = $data_c['total'];
          $is_full = $current >= $row['maxParticipants'];
          ?>
          <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0">
              <div class="card-body">
                <span class="badge bg-primary mb-2"><?php echo $row['eventType']; ?></span>
                <h4 class="card-title"><?php echo $row['eventName']; ?></h4>
                <h6 class="text-muted"><?php echo $row['eventSubCategory']; ?></h6>
                <p class="card-text small mt-3"><?php echo $row['eventDescription']; ?></p>
                <hr>
                <p class="mb-1"><i class="bi bi-geo-alt"></i> <?php echo $row['eventAddress']; ?></p>
                <p class="mb-1"><i class="bi bi-calendar"></i> <?php echo $row['eventDate']; ?> |
                  <?php echo $row['eventTime']; ?>
                </p>

                <div class="mt-3">
                  <small class="<?php echo $is_full ? 'text-danger fw-bold' : 'text-success fw-bold'; ?>">
                    Slots: <?php echo $current; ?> / <?php echo $row['maxParticipants']; ?>
                  </small>
                </div>
              </div>
              <div class="card-footer bg-white border-top-0 pb-3">
                <?php if ($is_full): ?>
                  <button class="btn btn-secondary w-100" disabled>Fully Booked</button>
                <?php else: ?>
                  <form method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $eid; ?>">
                    <button type="submit" name="join_event_btn" class="btn btn-warning w-100">Join Event</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>