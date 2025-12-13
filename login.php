<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

$error = "";

if (isset($_POST['login_btn'])) {
  $input = $_POST['login_input'];
  $password = $_POST['password'];

  // 1. Check Admin (Direct Query)
  $sql_admin = "SELECT * FROM admins WHERE username = '$input' AND password = '$password'";
  $res_admin = mysqli_query($conn, $sql_admin);

  if (mysqli_num_rows($res_admin) > 0) {
    $row = mysqli_fetch_assoc($res_admin);
    $_SESSION['admin_id'] = $row['adminID'];
    $_SESSION['name'] = $row['firstName'];
    $_SESSION['role'] = 'admin';
    header("Location: admin/dashboard.php");
  }

  // 2. Check User (Direct Query)
  $sql_user = "SELECT * FROM users WHERE email = '$input' AND password = '$password'";
  $res_user = mysqli_query($conn, $sql_user);

  if (mysqli_num_rows($res_user) > 0) {
    $row = mysqli_fetch_assoc($res_user);
    $_SESSION['user_id'] = $row['userID'];
    $_SESSION['name'] = $row['firstName'];
    $_SESSION['role'] = 'user';
    header("Location: profile.php");
  }

  // If code reaches here, login failed
  $error = "Invalid Login Credentials";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Login - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card shadow p-4" style="width: 400px;">
    <div class="text-center mb-4">
      <h2 class="text-primary">MotionFest</h2>
      <p>Sign In</p>
    </div>
    <?php if ($error != ""): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Email (User) or Username (Admin)</label>
        <input type="text" name="login_input" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" name="login_btn" class="btn btn-primary w-100"
        style="background-color: var(--accent-color); border:none;">Login</button>
    </form>
    <p class="text-center mt-3">New Athlete? <a href="register.php">Register Here</a></p>
    <p class="text-center"><a href="index.php">Back to Home</a></p>
  </div>
</body>

</html>