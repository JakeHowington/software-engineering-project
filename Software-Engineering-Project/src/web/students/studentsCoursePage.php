<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "STUDENT");

include_once "../../dao/SurveyDAO.php";
include_once "../../dao/CourseDAO.php";
include_once "../../dao/TeamMembershipDAO.php";
$surveyDAO = new SurveyDAO();
$courseDAO = new CourseDAO();
$teammembershipDAO = new TeamMembershipDAO;

$courseID = $_GET['course_id'] ?? null;
$account_id = $_SESSION['ACCOUNTID'];

// Fetch surveys for the given course ID
$course = $courseDAO->findById($courseID);
$managers = $courseDAO->getCourseManagers($courseID);
$uncompletedSurveys = $surveyDAO->getUncompletedSurveys($courseID, $_SESSION['ACCOUNTID']);
$completedSurveys = $surveyDAO->getCompletedSurveys($courseID, $_SESSION['ACCOUNTID']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <?php include_once "studentNavbar.php" ?>
    <div class="container text-center">
        <div class="mt-4">
            <h1 class="mt-3"><?= htmlspecialchars($course['COURSENAME']); ?></h1>
            <h3 class="text-secondary">CS <?= htmlspecialchars($course['COURSENUMBER']); ?></h3>
            <?php
            foreach ($managers as $manager) : ?>
                <h3 class="text-secondary"><?= $manager['USERFNAME'], " ", $manager['USERLNAME']; ?></p>
                <?php endforeach; ?>
        </div>


        <div class="row mt-4">
            <?php
            // autopopulating cards to view surveys

            foreach ($uncompletedSurveys as $survey) :
                $teamid = $teammembershipDAO->getTeamID($_SESSION['ACCOUNTID'],$survey['SURVEYID']);
                $team = $surveyDAO->getTeamMembers($survey['SURVEYID'],$teamid['TEAMID']); ?>
                <div class="col-md-4" style="width:100%; margin-bottom:20px;">
                    <div class="card mb-4 shadow-sm" , style="height: 100%">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($survey['SURVEYTITLE']); ?></h5>
                            <?php
                            foreach ($team as $member) : ?>
                                <p class="card-text"><?= $member['USERFNAME'], " ", $member['USERLNAME']; ?></p>
                            <?php endforeach; ?>

                        </div>
                        <div class="d-flex justify-content-center align-content-end" style="margin-bottom: 10px;">
                                <!-- replace these actions once the proper pages are created -->
                                <form action="takeSurvey.php" method="POST" class="me-2">
                                    <input type="hidden" name="survey_id" value="<?= $survey['SURVEYID']; ?>">
                                    <button type="submit" class="btn btn-info">Take Survey</button>
                                </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            foreach ($completedSurveys as $survey) :
                //only one person per survey, so only 1 team
                $teamid = $teammembershipDAO->getTeamID($_SESSION['ACCOUNTID'],$survey['SURVEYID']);
                $team = $surveyDAO->getTeamMembers($survey['SURVEYID'],$teamid['TEAMID']); ?>
                <div class="col-md-4" style="width:100%; margin-bottom:20px;">
                    <div class="card mb-4 shadow-sm" , style="height: 100%">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($survey['SURVEYID']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($survey['SURVEYTITLE']); ?></p>
                            <?php
                            foreach ($team as $member) : ?>
                                <p class="card-text"><?= $member['USERFNAME'], " ", $member['USERLNAME']; ?></p>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


    </div>
</body>

</html>