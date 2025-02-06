<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the Account table
 */
Class AccountDAO extends AbstractDAO{

    /**
     * Retrieves all rows from the database table.
     * @return mysqli_result Returns a mysqli_result object containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM ACCOUNT");
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
        $stmt = $this->connection->prepare("SELECT * FROM ACCOUNT WHERE ACCOUNTID = ?");
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
        $stmt = $this->connection->prepare("INSERT INTO ACCOUNT (EMAIL, PASSWORD, USERFNAME, USERLNAME, USERTYPE) VALUES(?,?,?,?,?)");
        $EMAIL = $data['EMAIL'];
        $PASSWORD = $data['PASSWORD'];
        $USERFNAME = $data['USERFNAME'];
        $USERLNAME = $data['USERLNAME'];
        $USERTYPE = $data['USERTYPE'];
        $stmt->bind_param("sssss", $EMAIL, $PASSWORD, $USERFNAME, $USERLNAME, $USERTYPE);
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
        $stmt = $this->connection->prepare("UPDATE ACCOUNT SET EMAIL = ?, PASSWORD = ?, USERFNAME = ?, USERLNAME = ?, USERTYPE = ? WHERE ACCOUNTID = ? ");
        $ACCOUNTID = $data['ACCOUNTID'];
        $EMAIL = $data['EMAIL'];
        $PASSWORD = $data['PASSWORD'];
        $USERFNAME = $data['USERFNAME'];
        $USERLNAME = $data['USERLNAME'];
        $USERTYPE = $data['USERTYPE'];
        $stmt->bind_param("sssssi", $EMAIL, $PASSWORD, $USERFNAME, $USERLNAME, $USERTYPE, $ACCOUNTID);
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
        $stmt = $this->connection->prepare("DELETE FROM ACCOUNT WHERE ACCOUNTID = ?");
        $stmt->bind_param("i", $id);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }

    /**
     * Retrieves a single row from the database table by its email.
     * @param string $email The email of the row to retrieve.
     * @return array Returns an associative array containing the row.
     */
    public function findByEmail($email){
        $stmt = $this->connection->prepare("SELECT * FROM ACCOUNT WHERE EMAIL = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }
}

?>