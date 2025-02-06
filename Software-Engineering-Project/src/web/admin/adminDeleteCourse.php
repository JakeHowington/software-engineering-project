<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/CourseDAO.php";
$courseDAO = new CourseDAO();

$courseID = $_GET['courseID'];

$courseDAO->delete($courseID);

header("Location: adminManageCourses.php");

?>