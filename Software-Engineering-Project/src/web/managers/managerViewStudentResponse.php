<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

include_once "../../dao/QuestionDAO.php";
include_once "../../dao/ResponseDAO.php";
$questionDAO = new QuestionDAO();
$responseDAO = new ResponseDAO();

$surveyID = $_GET['surveyID'];
$accountID = $_GET['accountID'];

$questions = $questionDAO->getOrderedSurveyQuestion($surveyID);

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Response</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style/style.css">   
</head>
<body>
    <?php include_once "managerNavbar.php"; ?>   

    <div class="container">
        <h1 class="text-center">Student's Response</h1>
        <br>
        <?php foreach($questions as $question): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $question['QUESTION']; ?></h5>
                    <p class="card-text">
                        <?php 
                        $response = $responseDAO->getUserResponse($accountID, $question['QUESTIONID']);
                        if ($response != NULL) {
                            $qType = $question['QUESTIONTYPE'];
                            switch ($qType) {
                                case 'RRESPONSE':
                                    echo $response['RRESPONSE'];
                                    break;
                                case 'PRESPONSE':
                                    echo $response['PRESPONSE'];
                                    break;
                                case 'ORESPONSE':
                                    echo $response['ORESPONSE'];
                                    break;
                                case 'NRESPONSE':
                                    echo $response['NRESPONSE'];
                                    break;
                                default:
                                    echo "Invalid question type.";
                            }
                        } else {
                            echo "No response.";
                        }
                        ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>
</html>