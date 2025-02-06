<?php

/**
 * Script to authenticate a user. This script is called when the user submits the login form.
 */

require_once 'UserAuthentication.php'; // add the UserAuthentication.php file
session_start(); //Start the session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Get the password directly, don't hash it here

    $userAuthentication = new UserAuthentication();
    $isValidUser = $userAuthentication->authTF($email, $password);

    if ($isValidUser) {

      exit;
    } else {
      // Show an error message
      $message = "Invalid email or password.";
      echo "<script type='text/javascript'>alert('$message');</script>";
    }
  } else if (isset($_POST['redirect'])) {
    header("Location: ./registrationPage.php");
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./style/style.css">
</head>

<body>
  <div>
    <h1> Welcome to the <span class="NOP">Numa Open Poll</span> System</h1>
  </div>
  <div class="container d-flex justify-content-center align-items-center">
    <form class="login_form" action="login.php" method="POST">
      <legend>Login</legend>
      <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
      <input name="password" type="password" class="form-control" id="password" placeholder="Password" autocomplete="off">
      <button type="submit" name="submit" class="register_button gradient">Submit</button>
    </form>
  </div>
  <div class="container d-flex justify-content-center align-items-center">
    <p>Don't have an account? <a href="./registrationPage.php">Register</a></p>
  </div>
  </div>
</body>

</html>