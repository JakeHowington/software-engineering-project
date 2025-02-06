<?php

    $db = new NopDBCalls();
    if($db->getAccountId($USER->email) == false){
        echo '<div class="alert alert-success nop-alert" role="alert">Looks like you are all caught up on your surveys!</div>';
    }else{
        $accountId = $db->getAccountId($USER->email);
        $surveys = $db->getAllAssignedSurveys($accountId);
        if($surveys == false){
            echo '<div class="alert alert-success nop-alert" role="alert">Looks like you are all caught up on your surveys!</div>';
        }else{
            if($db->checkOpen($surveys, $accountId)){
                mysqli_data_seek($surveys, 0);
                echo '<div class="nop-dropdownform"> <form action="./takesurveys.php" method="POST"> <div class="nop-dropdown"> <select id="surveyId" name="surveyId" class="nop-select-field" required>';
                while($row = $surveys->fetch_assoc()){
                    if($db->isOpen($accountId, $row['SURVEYID'])){
                        $survey = $db->getSurvey($row['SURVEYID']);
                        echo '<option name = sruveyId value="'.$survey['SURVEYID'].'">'.$survey['SURVEYTITLE'].'</option>';
                    }
                }
                echo '<input type="hidden" name="accountId" value="'.$accountId.'">';
                echo '<input type="hidden" name="submitSurvey" value="false">';
                echo '</select> </div> <div class="nop-submit"><button type="submit" class="btn btn-dark">Take Survey</button></div></form></div>';
            }else{
                echo '<div class="alert alert-success nop-alert" role="alert">Looks like you are all caught up on your surveys!</div>';
            }
        }
    }
    $db->close();
?>

