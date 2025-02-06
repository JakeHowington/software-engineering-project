<?php
  include_once "../checkAuth.php";
  validateUser($_SESSION['USERTYPE'], "ADMIN");

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['course'])){
        header("Location: ./adminManageCourses.php");
    }else if(isset($_POST['user'])){
        header("Location: ./adminManageUsers.php");
    }
  } 

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Numa Open Poll Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootswatch/dist/superhero/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include_once "adminNavbar.php" ?>

    <!-- Hero Image -->
    <div class="hero-img">
        <h1 class="hero-text">Welcome to the <span class=NOP>Numa Open Poll</span> Dashboard</h1>
    </div>
    
    <div class = "container d-flex justify-content-center align-items-center">
        
        <form method="POST" action="landing_admin.php">
            <div class="card text-white mb-3 admin-cards">
                <div class="card-body">
                    <h2 class="card-title admin-cardtext">Manage Courses</h2>
                    <div class="admin-cardtext">
                    <button type="submit" name="course" class="btn btn-dark admin-button">Enter</button>
                    </div>
                </div>
            </div>

            <div class="card text-white mb-3 admin-cards">
                <div class="card-body">
                    <h2 class="card-title admin-cardtext">Manage Users</h2>
                    <div class="admin-cardtext">
                    <button type="submit" name="user" class="btn btn-dark admin-button">Enter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>&copy; 2024 Numa Open Poll System</footer>



</body>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>