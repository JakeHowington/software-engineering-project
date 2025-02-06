<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the response table
 */
Class ResponseDAO extends AbstractDAO{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM RESPONSE");
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
        $stmt = $this->connection->prepare("SELECT * FROM RESPONSE WHERE RESPONSEID = ?");
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
    public function insert(array $data){
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

    /**
     * Updates an existing row in the database table.
     * Note: if your call this method ecrypt password before calling. 
     * @param array $data An associative array containing the new data for the row.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function update(array $data){
        $stmt = $this->connection->prepare("UPDATE RESPONSE SET QUESTIONID = ?, ACCOUNTID = ?, RRESPONSE = ?, PRESPONSE = ?, ORESPONSE = ?, NRESPONSE = ? WHERE RESPONSEID = ? ");
        $QUESTIONID = $data['QUESTIONID'];
        $ACCOUNTID = $data['ACCOUNTID'];
        $RESPONSEID = $data['RESPONSEID'];

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

        $stmt->bind_param("iisdsii", $QUESTIONID, $ACCOUNTID, $RRESPONSE, $PRESPONSE, $ORESPONSE, $NRESPONSE, $RESPONSEID);
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
        $stmt = $this->connection->prepare("DELETE FROM RESPONSE WHERE RESPONSEID = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }

    public function getUserResponse($aid, $qid){
        $stmt = $this->connection->prepare("SELECT * FROM RESPONSE WHERE ACCOUNTID = ? AND QUESTIONID = ?");
        $stmt->bind_param("ii", $aid, $qid);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

}

?>