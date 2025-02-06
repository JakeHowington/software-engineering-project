<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

include_once "../../dao/SurveyDAO.php";
include_once "../../dao/CourseDAO.php";
$surveyDAO = new SurveyDAO();
$courseDAO = new CourseDAO();
$courseID = $_GET['course_id'] ?? null;

if(isset($_GET['popUp'])){
    $message = "That Survey Title has already been used. Please Choose another";
    echo "<script type='text/javascript'>alert('$message');</script>";
}

// Fetch surveys for the given course ID
$surveys = $surveyDAO->getSurveysByCourseID($courseID);
$course = $courseDAO->findById($courseID);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Manager Manage Surveys Page</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>
    <?php require_once "./managerNavbar.php" ?>

    <div class="container text-center">
        <div class="mt-4">
            <h1 class="mt-3"><?= htmlspecialchars($course['COURSENAME']); ?></h1>
            <h3 class="text-secondary">CS <?= htmlspecialchars($course['COURSENUMBER']); ?></h3>
        </div>

        <div class="row mt-4">
            <?php

            $i = 0;
            foreach ($surveys as $survey) :
                if ($i == 3) {
                    echo '</div>';
                    echo '<div class="row mt-4">';
                    $i = 0;
                }
            ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($survey['SURVEYID']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($survey['SURVEYTITLE']); ?></p>
                            <div class="d-flex justify-content-center">
                                <!-- change ahead of time -->
                                <form action="managerSurveyResponses.php" method="GET" class="me-2">
                                    <input type="hidden" name="surveyID" value="<?= $survey['SURVEYID']; ?>">
                                    <input type="hidden" name="courseID" value="<?php echo $courseID ?>">
                                    <button type="submit" class="btn btn-success">View Responses</button>
                                </form>
                                <form action="teamCreation.php" method="GET" class="me-2">
                                    <input type="hidden" name="surveyID" value="<?php echo $survey['SURVEYID']; ?>">
                                    <input type="hidden" name="courseID" value="<?php echo $courseID ?>">
                                    <button type="submit" class="btn btn-success">Create Team</button>
                                </form>
                                <form action="managerDeleteSurvey.php" method="POST">
                                    <input type="hidden" name="surveyID" value="<?php echo $survey['SURVEYID']; ?>">
                                    <input type="hidden" name="courseID" value="<?php echo $courseID; ?>">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                $i = $i + 1;
            endforeach; ?>
        </div>

        <!-- button to create survey... -->
        <div class="mt-4">
            <form action="./managerCreateSurvey.php" method="GET">
                <input type="hidden" name="course_id" value="<?php echo $courseID ?>">
                <button type="submit" class="btn btn-success">Create Survey</button>
            </form>
        </div>
    </div>
</body>

</html>