<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
}
$uid = $_SESSION['user_id'];

// Update Profile
if (isset($_POST['update_btn'])) {
  $fn = $_POST['firstName'];
  $ln = $_POST['lastName'];
  $ph = $_POST['phone'];
  $addr = $_POST['address'];
  $em = $_POST['email'];

  $sql = "UPDATE users SET firstName='$fn', lastName='$ln', phone='$ph', address='$addr', email='$em' WHERE userID=$uid";
  mysqli_query($conn, $sql);
  echo "<script>alert('Profile Updated');</script>";
}

$user_q = mysqli_query($conn, "SELECT * FROM users WHERE userID=$uid");
$user = mysqli_fetch_assoc($user_q);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Profile - MotionFest</title>
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
          <li><a href="logout.php" class="text-danger">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main mt-5 pt-5">
    <div class="container section">
      <div class="row">
        <div class="col-md-5 mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">My Information</div>
            <div class="card-body">
              <form method="POST">
                <div class="row mb-3">
                  <div class="col">
                    <label>First Name</label>
                    <input type="text" name="firstName" class="form-control" value="<?php echo $user['firstName']; ?>">
                  </div>
                  <div class="col">
                    <label>Last Name</label>
                    <input type="text" name="lastName" class="form-control" value="<?php echo $user['lastName']; ?>">
                  </div>
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>">
                </div>
                <div class="mb-3">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>">
                </div>
                <div class="mb-3">
                  <label>Address</label>
                  <textarea name="address" class="form-control" rows="2"><?php echo $user['address']; ?></textarea>
                </div>
                <button type="submit" name="update_btn" class="btn btn-primary w-100">Save Changes</button>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-7">
          <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">Joined Events</div>
            <div class="card-body">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Event Name</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Location</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT e.* FROM participants p JOIN events e ON p.eventID = e.eventID WHERE p.userID = $uid";
                  $res = mysqli_query($conn, $sql);
                  if (mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                      echo "<tr>
                            <td>{$row['eventName']}</td>
                            <td>{$row['eventType']} ({$row['eventSubCategory']})</td>
                            <td>{$row['eventDate']}</td>
                            <td>{$row['eventAddress']}</td>
                          </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4' class='text-center'>You haven't joined any events yet.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>