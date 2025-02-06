<?php

$db = new NopDBCalls();
$qth = new QTHandler();

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submitSurvey'] == "false"){
    
    $surveyId = $_POST['surveyId'];
    $accountId = $_POST['accountId'];
    $survey = $db->getSurvey($surveyId);
    $title = $survey['SURVEYTITLE'];
    $numQuestions = $survey['NUMQUESTIONS'];
    $questions = $db->getQuestions($surveyId);

    echo '<div class="nop-title"><h4>'.$title.'</h4></div>';
    echo '<div class="nop-form"><form action="./takesurveys.php" method="POST">';

    while($row = $questions->fetch_assoc()){
        if($row['QUESTIONTYPE'] == "ORESPONSE"){
            $qth->oresponse($row['QUESTION'], $row['QUESTIONNUM']);
        }
        if($row['QUESTIONTYPE'] == "PRESPONSE"){
            $qth->presponse($row['QUESTION'], $row['QUESTIONNUM']);
        }
        if($row['QUESTIONTYPE'] == "RRESPONSE"){
            if($db->isTeamBased($surveyId) == true){
                $teamMembers = $db->getTeamMembers($accountId, $surveyId);
                $qth->rresponse($row['QUESTION'], $row['QUESTIONNUM'], $teamMembers);
            }
        }
    }

    echo '<input type="hidden" name="accountId" value='.$accountId.'>';
    echo '<input type="hidden" name="surveyId" value='.$surveyId.'>';
    echo '<input type="hidden" name="numQuestions" value='.$numQuestions.'>';
    echo '<input type="hidden" name="submitSurvey" value="true">';
    echo '<div class="nop-submit"><button type="submit" class="btn btn-dark">Take Survey</button></div></form></div>';
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submitSurvey'] == 'true'){
    
    $numOfQuestions = $_POST['numQuestions'];
    $surveyId = $_POST['surveyId'];
    $accountId = $_POST['accountId'];
    $i = 0;

    while($i <= $numOfQuestions){
        $i++;
        $questionType = $db->getQuestionType($surveyId,$i);
        $questionId = $db->getQuestionId($surveyId,$i);
        if($questionType == "ORESPONSE"){  
            $qth->insertOresponse($questionId, $accountId, $_POST[$i]);
        }
        if($questionType == "PRESPONSE"){  
            $qth->insertPresponse($questionId, $accountId, $_POST[$i]);
        }
        if($questionType == "RRESPONSE"){  
            if($db->isTeamBased($surveyId) == true){
                $teamMembers = $db->getTeamMembers($accountId, $surveyId);
                $teamSize = $_POST['teamSize'];
                $x=1;
                $response = "";
                while($x <= $teamSize){
                    $name = $i."".$x;
                    $ranked = $_POST[$name];
                    if($x==1){
                        $response .= $teamMembers[$x].",".$ranked;
                    }else{
                        $response .= ",".$teamMembers[$x].",".$ranked;
                    }
                    $x++;
                }
                $qth->insertRresponse($questionId, $accountId, $response);
            }
        }
        
    }

    $url = new moodle_url('/blocks/nop/surveyfiles/checksurveys.php');
    redirect($url);
}
$db->close();
?>