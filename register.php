<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "motionfestdb");

if (isset($_POST['register_btn'])) {
  $fname = $_POST['firstName'];
  $lname = $_POST['lastName'];
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $phone = $_POST['phone'];
  $addr = $_POST['address'];

  $sql_check = "SELECT * FROM users WHERE email='$email'";
  $check_result = mysqli_query($conn, $sql_check);

  if (mysqli_num_rows($check_result) > 0) {
    echo "<script>alert('This user is already registered! Please login');</script>";
  } else {
    // Direct Insert
    $sql = "INSERT INTO users (firstName, lastName, email, password, phone, address) 
            VALUES ('$fname', '$lname', '$email', '$pass', '$phone', '$addr')";

    mysqli_query($conn, $sql);
    echo "<script>alert('Account created! Please login.'); window.location.href='login.php';</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Register - MotionFest</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow p-4">
          <h3 class="text-center mb-4">Join MotionFest</h3>
          <form method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="firstName" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="lastName" class="form-control" required>
              </div>
            </div>
            <div class="mb-3">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Address</label>
              <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="register_btn" class="btn btn-primary w-100"
              style="background-color: var(--accent-color); border:none;">Create Account</button>
          </form>
          <p class="text-center mt-3">Have an account? <a href="login.php">Login here</a></p>
        </div>
      </div>
    </div>
  </div>
</body>

</html>