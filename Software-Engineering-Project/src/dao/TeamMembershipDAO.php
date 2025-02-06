<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the team membership table
 */
Class TeamMembershipDAO extends AbstractDAO{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM TEAMMEMBERSHIP");
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
    public function findById($id){
        $stmt = $this->connection->prepare("SELECT * FROM TEAMMEMBERSHIP WHERE MEMBERSHIPID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function getAllStudentsBySurveyId($id) {
        $stmt = $this->connection->prepare("SELECT A.ACCOUNTID, A.USERFNAME, A.USERLNAME, T.TEAMID, T.TEAMNAME FROM SURVEY S JOIN TEAMMEMBERSHIP TM ON S.SURVEYID = TM.SURVEYID 
        JOIN TEAM T ON TM.TEAMID = T.TEAMID JOIN ACCOUNT A ON TM.ACCOUNTID = A.ACCOUNTID WHERE S.SURVEYID = ?;");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    /**
     * Inserts a new row into the database table.
     * Note: if your call this method ecrypt password before calling. 
     * @param array $data An associative array containing the data to insert.
     * @return bool Returns true if the insert was successful, false otherwise.
     */
    public function insert(array $data){
        $stmt = $this->connection->prepare("INSERT INTO TEAMMEMBERSHIP (TEAMID, ACCOUNTID, SURVEYID) VALUES(?,?,?)");
        $TEAMID = $data['TEAMID'];
        $ACCOUNTID = $data['ACCOUNTID'];
        $SURVEYID = $data['SURVEYID'];
        $stmt->bind_param("iii", $TEAMID, $ACCOUNTID, $SURVEYID);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
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
    public function update(array $data){
        $stmt = $this->connection->prepare("UPDATE TEAMMEMBERSHIP SET TEAMID = ?, ACCOUNTID = ?, SURVEYID = ? WHERE MEMBERSHIPID = ?");
        $TEAMID = $data['TEAMID'];
        $ACCOUNTID = $data['SURVEYID'];
        $SURVEYID = $data['SURVEYID'];
        $MEMBERSHIPID = $data['MEMBERSHIPID'];
        $stmt->bind_param("iiii", $TEAMID, $ACCOUNTID, $SURVEYID, $MEMBERSHIPID);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }

    /**
     * Deletes a row from the database table by its primary key.
     * @param mixed $id The primary key of the row to delete.
     * @return bool Returns true if the delete was successful, false otherwise.
     */
    public function delete($id){
        $stmt = $this->connection->prepare("DELETE FROM TEAMMEMBERSHIP WHERE MEMBERSHIPID = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }

    public function getTeamsBySurvey($id){
        $stmt = $this->connection->prepare("SELECT DISTINCT TEAMID FROM TEAMMEMBERSHIP WHERE SURVEYID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    
    public function getTeamID($aid, $sid){
        $stmt = $this->connection->prepare("SELECT TEAMID FROM TEAMMEMBERSHIP WHERE ACCOUNTID = ? AND SURVEYID = ?");
        $stmt->bind_param("ii", $aid, $sid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

}

?>