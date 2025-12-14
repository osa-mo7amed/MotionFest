<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

if (!isset($_SESSION['admin_id'])) {
  header("Location: ../login.php");
}

$sql = "SELECT p.*, u.firstName, u.lastName, u.email, e.eventName 
        FROM participants p 
        JOIN users u ON p.userID = u.userID 
        JOIN events e ON p.eventID = e.eventID";

// Search via POST
if (isset($_POST['search_btn'])) {
  $q = $_POST['q'];
  $sql .= " WHERE u.firstName LIKE '%$q%' OR u.lastName LIKE '%$q%' OR e.eventName LIKE '%$q%'";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Participants</title>
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/main.css" rel="stylesheet">
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
      <div class="d-flex justify-content-between mb-4">
        <h3>Participants List</h3>
        <form method="POST" class="d-flex">
          <input type="text" name="q" class="form-control me-2" placeholder="Search...">
          <button type="submit" name="search_btn" class="btn btn-primary">Search</button>
        </form>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead class="table-dark">
            <tr>
              <th>Participant ID</th>
              <th>User Name</th>
              <th>Email</th>
              <th>Event Joined</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $res = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($res)) {
              echo "<tr>
                        <td>{$row['participantID']}</td>
                        <td>{$row['firstName']} {$row['lastName']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['eventName']}</td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>