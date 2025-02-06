<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the team table
 */
Class TeamDAO extends AbstractDAO{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM TEAM");
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
        $stmt = $this->connection->prepare("SELECT * FROM TEAM WHERE TEAMID = ?");
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
        $stmt = $this->connection->prepare("INSERT INTO TEAM (COURSEID, TEAMNAME) VALUES(?,?)");
        $COURSEID = $data['COURSEID'];
        $TEAMNAME = $data['TEAMNAME'];
        $stmt->bind_param("is", $COURSEID, $TEAMNAME);
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
        $stmt = $this->connection->prepare("UPDATE TEAM SET COURSEID = ?, TEAMNAME = ? WHERE TEAMID = ? ");
        $COURSEID = $data['COURSEID'];
        $TEAMNAME = $data['TEAMNAME'];
        $TEAMID = $data['TEAMID'];
        $stmt->bind_param("isi", $COURSEID, $TEAMNAME, $TEAMID);
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
        $stmt = $this->connection->prepare("DELETE FROM TEAM WHERE TEAMID = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }

    public function getLastInsertedId() {
        return $this->connection->insert_id;
    }

}

?>