<?php

include_once "../checkAuth.php";
validateUser($_SESSION['USERTYPE'], "STUDENT");

require_once('../../dao/ResponseDAO.php');
require_once('../../dao/QuestionDAO.php');

require_once('../../dao/TeamMembershipDAO.php');

$TeamMembershipDAO = new TeamMembershipDAO();

$survey_id = $_POST["survey_id"];

$ResponseDAO = new ResponseDAO();
$QuestionDAO = new QuestionDAO();

$question_number = ($QuestionDAO->getNumQuestions($survey_id));

$result = $TeamMembershipDAO->getAllStudentsBySurveyId($survey_id);

$members = array();

while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

$count = 1;


// maybe pass the survey id over in post too 
// so we can query db for number of questions for incrementer

while ($count <= $question_number) {

    $response_data = NULL;

    $response_data['QUESTIONID'] = $_POST['question_id' . $count];
    $response_data['ACCOUNTID'] = $_POST['student_id'];

    $response_type = $_POST['response_type' . $count];


    // maybe need a switch stmt here

    switch ($response_type) {

        case "RRESPONSE" . $count:

            $trunc_response_type = preg_replace('/\d+$/', '', $response_type);

            $string = "";

            // echo count($members);

            $r_count = $count;

            while($r_count < (count($members) + $count)) {
                
                $string = $string . $_POST["fname" . $r_count] . ',' . $_POST["rank" . $r_count];
                $r_count++;

            }

            echo $string;

            $response_data[$trunc_response_type] = $string;

            $ResponseDAO->insert($response_data);

            break;

        case "PRESPONSE" . $count:
            $pvalue = floatval($_POST['percentage' . $count]);
            $trunc_response_type = preg_replace('/\d+$/', '', $response_type);
            $response_data[$trunc_response_type] = $pvalue;
            $ResponseDAO->insert($response_data);
            break;

        case "ORESPONSE" . $count:
            $trunc_response_type =  preg_replace('/\d+$/', '', $response_type);
            $response_data[$trunc_response_type] = $_POST['response' . $count];

            $ResponseDAO->insert($response_data);
            break;

        case "NRESPONSE" . $count:

            break;
    }

    $count++;

    Header('Location: ./landing_students.php');
}
