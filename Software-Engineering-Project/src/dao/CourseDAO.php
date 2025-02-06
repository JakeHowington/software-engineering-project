<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the Course table
 */
class CourseDAO extends AbstractDAO{
    
    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM COURSE");
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
        $stmt = $this->connection->prepare("SELECT * FROM COURSE WHERE COURSEID = ?");
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
        $stmt = $this->connection->prepare("INSERT INTO COURSE (COURSENAME, COURSENUMBER) VALUES(?,?)");
        $COURSENAME = $data['COURSENAME'];
        $COURSENUMBER = $data['COURSENUMBER'];
        $stmt->bind_param("si",$COURSENAME, $COURSENUMBER);
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
        $stmt = $this->connection->prepare("UPDATE COURSE SET COURSENAME = ?, COURSENUMBER = ? WHERE COURSEID = ? ");
        $COURSEID = $data['COURSEID'];
        $COURSENAME = $data['COURSENAME'];
        $COURSENUMBER = $data['COURSENUMBER'];
        $stmt->bind_param("sii",$COURSENAME, $COURSENUMBER, $COURSEID);
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
        $stmt = $this->connection->prepare("DELETE FROM COURSE WHERE COURSEID = ?");
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
     * Retrieves all courses that a student is enrolled in.
     * @param mixed $student_id The primary key of the student.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function get_active_courses($student_id){
        $stmt = $this->connection->prepare("SELECT * FROM COURSE WHERE COURSEID IN (SELECT COURSEID FROM ENROLLMENT WHERE ACCOUNTID = ?)");
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /**
     * Retrieves course managers for given course ID.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function getCourseManagers($id)
    {
        $stmt = $this->connection->prepare("SELECT USERFNAME, USERLNAME FROM ACCOUNT A JOIN ENROLLMENT E ON A.ACCOUNTID = E.ACCOUNTID JOIN COURSE C ON E.COURSEID = C.COURSEID WHERE ISMANAGER = 1 AND E.COURSEID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

}

?>