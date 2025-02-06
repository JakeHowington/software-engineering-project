<?php
include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "ADMIN");

require_once '../../dao/EnrollmentDAO.php'; 

$enrollmentDAO = new EnrollmentDAO(); 
$courseID = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courseID = isset($_GET["courseID"]) ? $_GET["courseID"] : '';
    if ($courseID) {

        if (isset($_GET["add_selected"])) {    
                
            $selectedUsers = isset($_GET["selected_users"]) ? $_GET["selected_users"] : [];
            $atLeastOneInserted = false;
            foreach ($selectedUsers as $userId) {     
              
                $data = [
                    'ACCOUNTID' => $userId,
                    'COURSEID' => $courseID,
                    'ISMANAGER' => 1, 
                ];
                $inserted = $enrollmentDAO->insert($data);                   
            }  
            
            
        }
    }
}

header("Location: adminAddCourseManager.php?courseID=".$courseID);
exit();


?>