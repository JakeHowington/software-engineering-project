<?php

function handleResponseType($question_type, $count)
{

    $survey_id = 3;

    require_once('../../dao/TeamMembershipDAO.php');

    $TeamMembershipDAO = new TeamMembershipDAO();

    $result = $TeamMembershipDAO->getAllStudentsBySurveyId($survey_id);

    $members = array();

    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }

    switch ($question_type) {

        case "RRESPONSE":

            echo '<div>';

            foreach ($members as $member) {
            
                echo '<label class="form-label">' . $member["USERFNAME"] . '</label>';
                echo '<input type="hidden" name="fname' . $count . '" value="' . $member["USERFNAME"] .'">';
                echo '<input type="number" name="rank' . $count . '" class="form-control" min="1" max="' . count($members) . '" required>';

                $count++;
            }
            echo '</div>';

            break;

        case "PRESPONSE":
            echo '<div>';
            echo '<label class="form-label">Percentage (%)</label>';
            echo '<input type="range" class="form-range" id="customRange1" min="0" max="100" value="50" name="percentage' . $count . '">';
            echo '</div>';

            break;

        case "ORESPONSE":
            // TO-DO
            echo '<div>';
            echo '<label class="form-label">Response: </label>';
            echo '<textarea class="form-control" rows="3" name="response' . $count . '">';
            echo '</textarea>';

            echo '</div>';

            break;

        case "NRESPONSE":
            //TO-DO
            break;
    }

    $count++;
    return $count;
}
