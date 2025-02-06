<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

//include_once "../../dao/TeamMembershipDAO.php";
include_once "../../dao/SurveyDAO.php";
//$teamMembershipDAO = new TeamMembershipDAO();
$surveyDAO = new SurveyDAO();

$surveyID = $_GET['surveyID'];
$courseID = $_GET['courseID'];

//This can be used to show the teams for a survey which can then lead to another page to show the people in the team
//$teams = $teamMembershipDAO->getTeamsBySurvey($surveyID);
$users = $surveyDAO->getPotentialUsers($surveyID);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Responses</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include_once "managerNavbar.php"; ?>

    <div class="container text-center">
        <h1>Survey Responses</h1>

        <div class="row mt-4">
            <?php

            $i = 0;
            foreach ($users as $user) :
                if ($i == 3) {
                    echo '</div>';
                    echo '<div class="row mt-4">';
                    $i = 0;
                }
            ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body ">
                            <h5 class="card-title"><?php echo $user["USERFNAME"] . " " . $user["USERLNAME"]; ?></h5>
                            <p class="card-text"><?php echo $user["TEAMNAME"]; ?></p>
                            <div class="d-flex justify-content-center">
                                <!-- change ahead of time -->
                                <form action="managerViewStudentResponse.php" method="GET" class="me-2">
                                    <input type="hidden" name="surveyID" value="<?= $surveyID; ?>">
                                    <input type="hidden" name="accountID" value="<?php echo $user['ACCOUNTID'] ?>">
                                    <button type="submit" class="btn btn-success">View Results</button>
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

</body>


</html>