<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

include_once "../../dao/CourseDAO.php";
$courseDAO = new CourseDAO();

$number = $_GET['courseNumber'];
$name = $_GET['courseName'];

$course = ["COURSENUMBER" => $number, "COURSENAME"=> $name];

$courseDAO->insert($course);

header("Location: adminManageCourses.php");

?>