<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "STUDENT");

// Get student ID from session
$active_user = $_SESSION["ACCOUNTID"];

$survey_id = $_POST['survey_id'];



require_once('../../dao/QuestionDAO.php');

$QuestionDAO = new QuestionDAO();

$questions = $QuestionDAO->getAllQuestionsBySurveyId($survey_id);

require_once('./handleResponseType.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="../style/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <?php include_once "studentNavbar.php" ?>

    <!-- Questions container -->
    <div class="container" style="padding-top: 2%;">
        <form action="insertResponses.php" method="POST">
            <?php
            $count = 1;
            foreach ($questions as $question) {
                echo '<div class="container2">';
                echo '<h4 class="question-number">Question #' . $count . '</h4>';
                echo '<h5 class="question-text">' . $question["QUESTION"] . '</h5>';
                // Hidden inputs for survey data
                echo '<input type="hidden" name="survey_id" value="' . $survey_id . '">';
                echo '<input type="hidden" name="question_id' . $count .'" value="' . $question["QUESTIONID"]  .'">';
                echo '<input type="hidden" name="student_id" value="' . $active_user  . '">';
                echo '<input type="hidden" name="response_type' . $count . '" value="' . $question["QUESTIONTYPE"] . $count .  '">';
                $count = handleResponseType($question["QUESTIONTYPE"], $count);
                echo '</div>';
            }
            ?>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary submit-button admin-button">Submit Survey</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
