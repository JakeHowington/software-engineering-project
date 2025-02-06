<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

require_once("../../dao/CourseDAO.php");
$courseDAO = new CourseDAO();

$active_user = $_SESSION['ACCOUNTID'];

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Numa Open Poll System</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>
    <?php include_once "./managerNavbar.php" ?>

    <!-- Hero Image -->
    <div class="hero-img">
        <h1 class="hero-text">Welcome to the Numa Open Poll System</h1>
    </div>

    <!-- Header for availible Courses -->
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Jump into your courses</h1>
            </div>
        </div>
    </div>


    <div class="container">

        <div class="row mt-4 text-center">
            <?php

            $courses = $courseDAO->get_active_courses($active_user);
            $i = 0;
            foreach ($courses as $course) :
                if ($i == 3) {
                    echo '</div>';
                    echo '<div class="row mt-4 text-center">';
                    $i = 0;
                }
            ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3"><?= $course['COURSENUMBER'].' - '.$course['COURSENAME'] ?></h5>
                            <div class="d-flex justify-content-center">
                                <form action="managerManageSurveys.php" method="GET" class="me-2">
                                    <input type="hidden" name="course_id" value="<?php echo $course['COURSEID'] ?>">
                                    <button type="submit" class="btn btn-primary">View Course</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $i = $i + 1;
            endforeach; ?>
        </div>
    </div>

    
    <div class=" text-center">
        &copy; 2024 Numa Open Poll System
    </div>
</body>
    
</html>