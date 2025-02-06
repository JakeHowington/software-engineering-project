<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the Survey table.
 */
class SurveyDAO extends AbstractDAO
{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll()
    {
        $stmt = $this->connection->prepare("SELECT * FROM SURVEY");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;

    }

    /**
     * Retrieves team members for a survey.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function getTeamMembers($sid, $tid)
    {
        $stmt = $this->connection->prepare("SELECT USERFNAME, USERLNAME FROM ACCOUNT A JOIN TEAMMEMBERSHIP T ON A.ACCOUNTID = T.ACCOUNTID WHERE SURVEYID = ? AND T.TEAMID = ?");
        $stmt->bind_param("ii", $sid, $tid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;

    }

    /**
     * Retrieves team members for a survey.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function getUncompletedSurveys($cid, $aid)
    {
        $stmt = $this->connection->prepare("SELECT S.SURVEYID, S.SURVEYTITLE FROM SURVEY S WHERE S.COURSEID = ? EXCEPT SELECT S.SURVEYID, S.SURVEYTITLE 
        FROM SURVEY S JOIN QUESTION Q ON S.SURVEYID = Q.SURVEYID JOIN RESPONSE R ON R.QUESTIONID = Q.QUESTIONID WHERE S.COURSEID = ? AND R.ACCOUNTID = ?");
        $stmt->bind_param("iii", $cid, $cid, $aid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;

    }

    /**
     * Retrieves team members for a survey.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function getCompletedSurveys($cid, $aid){
        $stmt = $this->connection->prepare("SELECT DISTINCT S.SURVEYID, S.SURVEYTITLE FROM SURVEY S JOIN QUESTION Q ON S.SURVEYID = Q.SURVEYID 
        JOIN RESPONSE R ON R.QUESTIONID = Q.QUESTIONID WHERE S.COURSEID = ? AND R.ACCOUNTID = ?");
        $stmt->bind_param("ii", $cid, $aid);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    /**
     * Retrieves a single row from the database table by its primary key.
     * @param mixed $id The primary key of the row to retrieve.
     * @return array Returns an associative array containing the row.
     */
    public function findById($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM SURVEY WHERE SURVEYID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    /**
     * Inserts a new row into the database table.
     * Note: if your call this method ecrypt password before calling. 
     * @param array $data An associative array containing the data to insert.
     * @return bool Returns true if the insert was successful, false otherwise.
     */
    public function insert(array $data)
    {
        $stmt = $this->connection->prepare("INSERT INTO SURVEY (COURSEID, SURVEYTITLE, TEAMBASED, NUMQUESTIONS) VALUES(?,?,?,?)");
        $COURSEID = $data['COURSEID'];
        $SURVEYTITLE = $data['SURVEYTITLE'];
        $TEAMBASED = $data['TEAMBASED'];
        $NUMQUESTIONS = $data['NUMQUESTIONS'];
        $stmt->bind_param("isii", $COURSEID, $SURVEYTITLE, $TEAMBASED, $NUMQUESTIONS);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    /**
     * Updates an existing row in the database table.
     * Note: if your call this method ecrypt password before calling. 
     * @param array $data An associative array containing the new data for the row.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function update(array $data)
    {
        $stmt = $this->connection->prepare("UPDATE SURVEY SET COURSEID = ?, SURVEYTITLE = ?, TEAMBASED = ?, NUMQUESTIONS = ? WHERE SURVEYID = ? ");
        $COURSEID = $data['COURSEID'];
        $SURVEYTITLE = $data['SURVEYTITLE'];
        $TEAMBASED = $data['TEAMBASED'];
        $NUMQUESTIONS = $data['NUMQUESTIONS'];
        $SURVEYID = $data['SURVEYID'];
        $stmt->bind_param("isiii", $COURSEID, $SURVEYTITLE, $TEAMBASED, $NUMQUESTIONS, $SURVEYID);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    /**
     * Deletes a row from the database table by its primary key.
     * @param mixed $id The primary key of the row to delete.
     * @return bool Returns true if the delete was successful, false otherwise.
     */
    public function delete($id)
    {
        $stmt = $this->connection->prepare("DELETE FROM SURVEY WHERE SURVEYID = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    /**
     * Fetches all surveys that are in the specified course id that is passed in.
     * @param mixed $id The id of the desired course to find surveys from.
     * @return array Returns an associative array of surveys in a specific course.
     */
    public function getSurveysByCourseID($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM SURVEY S JOIN COURSE C ON S.COURSEID = C.COURSEID WHERE S.COURSEID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

        /**
     * Fetches a survey ID based of the survey title
     * @param mixed $title 
     * @return int returns an id of the survey
    */
    public function getSurveyIDbyTitle($title){
        $stmt = $this->connection->prepare("SELECT SURVEYID FROM SURVEY WHERE SURVEYTITLE = ?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['SURVEYID'];
    }

    /**
     * Checks if Survey Title exists
     * @param mixed $title 
     * @return boolean returns true or false if title is already used.
    */
    public function checkTitle($title){
        $stmt = $this->connection->prepare("SELECT SURVEYID FROM SURVEY WHERE SURVEYTITLE = ?");
        $stmt->bind_param("s", $title);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
    public function getPotentialUsers($id){
        $stmt = $this->connection->prepare("SELECT A.ACCOUNTID, A.USERFNAME, A.USERLNAME, T.TEAMID, T.TEAMNAME FROM SURVEY S JOIN TEAMMEMBERSHIP TM ON S.SURVEYID = TM.SURVEYID 
        JOIN TEAM T ON TM.TEAMID = T.TEAMID JOIN ACCOUNT A ON TM.ACCOUNTID = A.ACCOUNTID WHERE S.SURVEYID = ?;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}

?>