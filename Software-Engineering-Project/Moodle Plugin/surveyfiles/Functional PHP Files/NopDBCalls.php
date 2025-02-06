<?php

    class NopDBCalls {

        protected $host     = "localhost";
        protected $username = "admin";
        protected $password = "password";
        protected $database = "NOP";
        protected $connection;

        function __construct(){

            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
    
            #Check if the connection was successful
            if ($connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }

        function getAccountId($email){
            $stmt = $this->connection->prepare("SELECT ACCOUNTID FROM ACCOUNT WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if($result->num_rows == 0){
                return false;
            }else{
                $row = $result->fetch_assoc();
                return $row['ACCOUNTID'];
            }
        }

        function getAllAssignedSurveys($accountId){
            $stmt = $this->connection->prepare("SELECT SURVEYID FROM TEAMMEMBERSHIP WHERE ACCOUNTID = ? ");
            $stmt->bind_param("i", $accountId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            if($result->num_rows == 0){
                return false;
            }else{
                return $result;
            }
        }

        function getTeamMembers($accountId, $surveyId){
            $stmt1 = $this->connection->prepare("SELECT TEAMID FROM TEAMMEMBERSHIP WHERE ACCOUNTID = ? AND SURVEYID = ?");
            $stmt1->bind_param("ii", $accountId, $surveyId);
            $stmt1->execute();
            $result = $stmt1->get_result();
            $stmt1->close();
            $row = $result->fetch_assoc();
            $teamId = $row['TEAMID'];

            $stmt2 = $this->connection->prepare("SELECT ACCOUNTID FROM TEAMMEMBERSHIP WHERE TEAMID = ?");
            $stmt2->bind_param("i", $teamId);
            $stmt2->execute();
            $result2 = $stmt2->get_result();
            $stmt2->close();

            $teamMembers;
            $i = 0;

            while($row2 = $result2->fetch_assoc()){
                $memberId = $row2['ACCOUNTID'];
                if($memberId != $accountId){
                    $i++;
                    $stmt3 = $this->connection->prepare("SELECT USERFNAME FROM ACCOUNT WHERE ACCOUNTID = ?");
                    $stmt3->bind_param("i", $memberId);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    $stmt3->close();
                    $member = $result3->fetch_assoc();
                    $name = $member['USERFNAME'];
                    $teamMembers[$i] = $name;
                }
            }

            return $teamMembers;
        }

        function isOpen($accountId, $surveyId){
            $stmt = $this->connection->prepare("SELECT R.ACCOUNTID FROM RESPONSE R, QUESTION Q WHERE Q.QUESTIONID = R.QUESTIONID AND R.ACCOUNTID = ? AND Q.SURVEYID = ?");
            $stmt->bind_param("ii", $accountId, $surveyId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if($result->num_rows == 0){
                return true;
            }else{
                return false;
            }
        }

        function isTeamBased($surveyId){
            $stmt = $this->connection->prepare("SELECT TEAMBASED FROM SURVEY WHERE SURVEYID = ?");
            $stmt->bind_param("i", $surveyId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            if($row['TEAMBASED'] == true){
                return true;
            }else{
                return false;
            }
        }


        function getQuestions($surveyId){
            $stmt = $this->connection->prepare("SELECT * FROM QUESTION WHERE SURVEYID = ?");
            $stmt->bind_param("i", $surveyId);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            return $result;
        }

        function getQuestionType($surveyId, $questionNum){
            $stmt = $this->connection->prepare("SELECT QUESTIONTYPE FROM QUESTION WHERE SURVEYID = ? AND QUESTIONNUM = ?");
            $stmt->bind_param("ii", $surveyId, $questionNum);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $row = $result->fetch_assoc();
            return $row['QUESTIONTYPE'];
        }

        function getQuestionId($surveyId, $questionNum){
            $stmt = $this->connection->prepare("SELECT QUESTIONID FROM QUESTION WHERE SURVEYID = ? AND QUESTIONNUM = ?");
            $stmt->bind_param("ii", $surveyId, $questionNum);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $row = $result->fetch_assoc();
            return $row['QUESTIONID'];
        }

        function insertResponse($data){
            $stmt = $this->connection->prepare("INSERT INTO RESPONSE (QUESTIONID, ACCOUNTID, RRESPONSE, PRESPONSE, ORESPONSE, NRESPONSE) VALUES(?,?,?,?,?,?)");
            $QUESTIONID = $data['QUESTIONID'];
            $ACCOUNTID = $data['ACCOUNTID'];
    
            if (array_key_exists('RRESPONSE',$data)){
                $RRESPONSE = $data['RRESPONSE'];
            }else{
                $RRESPONSE = NULL;
            }
            if (array_key_exists('PRESPONSE',$data)){
                $PRESPONSE = $data['PRESPONSE'];
            }else{
                $PRESPONSE = NULL;
            }
            if (array_key_exists('ORESPONSE',$data)){
                $ORESPONSE = $data['ORESPONSE'];
            }else{
                $ORESPONSE = NULL;
            }
            if (array_key_exists('NRESPONSE',$data)){
                $NRESPONSE = $data['NRESPONSE'];
            }else{
                $NRESPONSE = NULL;
            }
    
            $stmt->bind_param("iisdsi", $QUESTIONID, $ACCOUNTID, $RRESPONSE, $PRESPONSE, $ORESPONSE, $NRESPONSE);
            if($stmt->execute()){
                $stmt->close(); 
                return true;
            }else{
                $stmt->close(); 
                return false;
            }
        }

        function getSurvey($surveyId){
            $stmt = $this->connection->prepare("SELECT * FROM SURVEY WHERE SURVEYID = ?");
            $stmt->bind_param("i", $surveyId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row;
        }

        function checkOpen($surveys, $accountId){
            while($row = $surveys->fetch_assoc()){
                if($this->isOpen($accountId, $row['SURVEYID'])){
                    return true;
                }
            }
            return false;
        }

        function close(){
            $this->connection->close();
        }

    }


?>