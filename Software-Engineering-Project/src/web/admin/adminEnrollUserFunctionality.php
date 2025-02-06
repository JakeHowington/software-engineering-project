<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/AccountDAO.php';
require_once '../../dao/CourseDAO.php';
require_once '../../dao/EnrollmentDAO.php'; 

$accountDAO = new AccountDAO();
$courseDAO = new CourseDAO();
$enrollmentDAO = new EnrollmentDAO(); 

$status = '';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courseId = isset($_GET["courseID"]) ? $_GET["courseID"] : '';

    if ($courseId) {

        if (isset($_GET["add_selected"])) {        
            $selectedUsers = isset($_GET["selected_users"]) ? $_GET["selected_users"] : [];
            $atLeastOneInserted = false;
            
            foreach ($selectedUsers as $userId) {                        
                if (!$enrollmentDAO->isEnrolled($userId, $courseId)) {
                    $data = [
                        'ACCOUNTID' => $userId,
                        'COURSEID' => $courseId,
                        'ISMANAGER' => 0, 
                    ];
                    $inserted = $enrollmentDAO->insert($data);                
                    if ($inserted) {
                        $atLeastOneInserted = true;
                    }
                }     
            }  
            
            $status = $atLeastOneInserted ? 'success' : 'failure';
            
        }
        
    } else {
        $status = 'missing_course_id';
    }
}

header("Location: adminEnrollUser.php?courseID=".$courseId."&status=$status");
exit();


?>