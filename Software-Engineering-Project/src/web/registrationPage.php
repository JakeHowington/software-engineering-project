<?php

/**
 * Script to Register a new User. 
 */

require_once '../dao/AccountDAO.php'; // add the UserAuthentication.php file
session_start(); //Start the session

# Create variables to store forms values
$accountDAO = new AccountDAO();
$email = $_POST['email'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$password = $_POST['password'];
$passwordCheck = $_POST['passwordCheck'];

# Check if the passwords match
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($password == $passwordCheck) {
    $data = array(
      "EMAIL" => $email,
      "PASSWORD" => hash("sha256", $password),
      "USERFNAME" => $fName,
      "USERLNAME" => $lName,
      "USERTYPE" => "STUDENT",
    );

    # Use AccountDAO insert to insert user into database. If successful redirect user to login page. 
    $isValid = $accountDAO->insert($data);

    if ($isValid) {
      header("Location: ./login.php");
    } else {
      $message = "Could Not Register User.";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  } else {
    $message = "Passwords Do Not Match.";
    echo "<script type='text/javascript'>alert('$message');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./style/style.css">
  <title>Registration</title>
</head>

<body>
  <div>
    <h1> Welcome to the <span class="NOP">Numa Open Poll</span> System</h1>
  </div>
  <div class="container d-flex justify-content-center align-items-center">
    <form class="login_form" action="registrationPage.php" method="POST">
      <legend>Get signed up!</legend>
      <input type="email" name="email" class="form-control" id="email" placeholder="Email">
      <input type="text" name="fName" class="form-control" id="fName" placeholder="First Name">
      <input type="text" name="lName" class="form-control" id="lName" placeholder="Last Name">
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
      <input type="password" name="passwordCheck" class="form-control" id="passwordCheck" placeholder="Re-Enter Password" autocomplete="off">
      <button type="submit" class="register_button gradient">Submit</button>
    </form>
  </div>

  <div class="container d-flex justify-content-center align-items-center">
    <p>Already have an account? <a href="./login.php">Login</a></p>
  </div>

  <footer>&copy; 2024 Numa Open Poll System</footer>
</body>

</html>