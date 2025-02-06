<?php

include_once './NopDBCalls.php';

    class QTHandler{

        public function oresponse($question, $questionNum){
            echo '<div class="nop-question"><h6>Question '.$questionNum.': '.$question.'</h6></div>';
            echo '<div class="nop-oresponse">';
            echo '<textarea class="form-control" id="openresponse" name="'.$questionNum.'" rows="3"></textarea>';
            echo '</div>';
        }

        public function presponse($question, $questionNum){
            echo '<div class="nop-question"><h6>Question '.$questionNum.': '.$question.'</h6></div>';
            echo '<div class="nop-presponse">';
            echo '<input type="range" value="50" min="1" max="100" name="'.$questionNum.'" oninput="this.nextElementSibling.value = this.value">';
            echo '<output>50</output>%';
            echo '</div>';
        }

        public function rresponse($question, $questionNum, $teamMembers){
            echo '<div class="nop-question"><h6>Question '.$questionNum.': '.$question.'</h6></div>';
            echo '<div class="nop-presponse">';
            $teamSize = count($teamMembers) - 1;
            $trueSize = count($teamMembers);
            $i=0;
            echo '<input type="hidden" name="'.$questionNum.'" value="true">';
            echo '<input type="hidden" name="teamSize" value='.$trueSize.'>';
            while($i <= $teamSize){
                $i++;
                $name = $questionNum."".$i;
                echo '<label for="'.$i.'">'.$teamMembers[$i].':</label>';
                echo '<input type="text" id="'.$i.'" name="'.$name.'"><br><br>';

            }
            echo '</div>';
        }

        public function insertOresponse($questionId, $accountId, $response){
            $db = new NopDBCalls();

            $data['QUESTIONID'] = $questionId;
            $data['ACCOUNTID'] = $accountId;
            $data['ORESPONSE'] = $response;
            $db->insertResponse($data);

            $db->close();

        }

        public function insertPresponse($questionId, $accountId, $response){
            $db = new NopDBCalls();

            $data['QUESTIONID'] = $questionId;
            $data['ACCOUNTID'] = $accountId;
            $data['ORESPONSE'] = $response;
            $db->insertResponse($data);

            $db->close();

        }

        public function insertRresponse($questionId, $accountId, $response){
            $db = new NopDBCalls();

            $data['QUESTIONID'] = $questionId;
            $data['ACCOUNTID'] = $accountId;
            $data['RRESPONSE'] = $response;
            $db->insertResponse($data);

            $db->close();

        }

    }


?>