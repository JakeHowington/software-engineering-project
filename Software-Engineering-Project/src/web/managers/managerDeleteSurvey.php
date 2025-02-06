<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "COURSEMANAGER");

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once "../../dao/SurveyDAO.php";
$surveyDAO = new SurveyDAO();

$surveyID = $_POST['surveyID'];
$courseID = $_POST['courseID'];

echo $courseID;

$surveyDAO->delete($surveyID);

header('Location: ./managerManageSurveys.php?course_id='.$courseID);

?>