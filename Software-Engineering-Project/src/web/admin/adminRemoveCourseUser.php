<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/EnrollmentDAO.php";
$enrollmentDAO = new EnrollmentDAO();

$courseID = $_GET['courseID'];
$accountID = $_GET['accountID'];

$user = [
    "COURSEID" => $courseID, 
    "ACCOUNTID"=> $accountID];

$enrollmentDAO->removeEnrollment($user);

header("Location: adminEditCourse.php?courseID=".$courseID);

?>