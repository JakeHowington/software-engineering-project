<?php
session_start();
//Check to see if a user is logged in
if (!isset($_SESSION['AUTHENTICATED']) || $_SESSION['AUTHENTICATED'] == false) {
    // Must have .. since these are included within /admin, /manager, and /student
    header("Location: ../login.php");
    exit();
}

function validateUser($userType, $typeRequired)
{
    // If the user type is correct, return and do nothing
    if ($userType == $typeRequired) {
        return;
    } else {
        //Otherwise, Grab the user type and send them to the correct landing page
        if ($userType == "STUDENT") {
            header("Location: ../students/landing_students.php");
            exit();
        } else if ($userType == "COURSEMANAGER") {
            header("Location: ../managers/landing_managers.php");
            exit();
        } else if ($userType == "ADMIN") {
            // header("Location: ../admin/landing_admin.php");
            header("Location: ./admin/adminManageCourses.php");
            exit();
        }
    }
}