<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

if (!isset($_SESSION['admin_id'])) {
  header("Location: ../login.php");
}

// Add Event (POST)
if (isset($_POST['add_btn'])) {
  $name = $_POST['eventName'];
  $type = $_POST['eventType'];
  $sub = $_POST['eventSubCategory'];
  $addr = $_POST['eventAddress'];
  $desc = $_POST['eventDescription'];
  $time = $_POST['eventTime'];
  $date = $_POST['eventDate'];
  $max = $_POST['maxParticipants'];

  $sql = "INSERT INTO events (eventName, eventType, eventSubCategory, eventAddress, eventDescription, eventTime, eventDate, maxParticipants) 
            VALUES ('$name', '$type', '$sub', '$addr', '$desc', '$time', '$date', '$max')";

  mysqli_query($conn, $sql);
}

// Delete Event (POST)
if (isset($_POST['delete_btn'])) {
  $id = $_POST['event_id'];
  $sql = "DELETE FROM events WHERE eventID = $id";
  mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Manage Events</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/main.css" rel="stylesheet">
</head>

<body>
  <header id="header" class="header d-flex align-items-center fixed-top bg-white shadow-sm">
    <div class="container-fluid container-xl d-flex justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <h1 class="sitename text-dark">MotionFest <span style="font-size:0.6em; color:var(--accent-color);">ADMIN</span></h1>
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
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">Add Event</div>
        <div class="card-body">
          <form method="POST">
            <div class="row g-2">
              <div class="col-md-6"><input type="text" name="eventName" class="form-control" placeholder="Event Name"
                  required></div>
              <div class="col-md-3"><input type="text" name="eventType" class="form-control"
                  placeholder="Type (e.g. Football)" required></div>
              <div class="col-md-3"><input type="text" name="eventSubCategory" class="form-control"
                  placeholder="Sub Cat (e.g. U-16)" required></div>

              <div class="col-md-6"><input type="text" name="eventAddress" class="form-control" placeholder="Address"
                  required></div>
              <div class="col-md-3"><input type="date" name="eventDate" class="form-control" required></div>
              <div class="col-md-3"><input type="time" name="eventTime" class="form-control" required></div>

              <div class="col-md-9"><input type="text" name="eventDescription" class="form-control"
                  placeholder="Description" required></div>
              <div class="col-md-3"><input type="number" name="maxParticipants" class="form-control"
                  placeholder="Max Quota" required></div>

              <div class="col-12"><button type="submit" name="add_btn" class="btn btn-success w-100">Create
                  Event</button></div>
            </div>
          </form>
        </div>
      </div>

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Date</th>
            <th>Quota</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = mysqli_query($conn, "SELECT * FROM events");
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                    <td>{$row['eventID']}</td>
                    <td>{$row['eventName']}</td>
                    <td>{$row['eventType']}</td>
                    <td>{$row['eventDate']}</td>
                    <td>{$row['maxParticipants']}</td>
                    <td>
                        <form method='POST' onsubmit='return confirm(\"Delete?\");'>
                            <input type='hidden' name='event_id' value='{$row['eventID']}'>
                            <button type='submit' name='delete_btn' class='btn btn-danger btn-sm'>Delete</button>
                        </form>
                    </td>
                </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>