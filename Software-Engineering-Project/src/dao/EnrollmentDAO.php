<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the Enrollment table
 */
Class EnrollmentDAO extends AbstractDAO{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll(){
        $stmt = $this->connection->prepare("SELECT * FROM ENROLLMENT");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    /**
     * Checks if a user with a given account ID is enrolled in a specific course.
     * @param int $accountId The account ID of the user.
     * @param int $courseId The course ID to check enrollment for.
     * @return bool Returns true if the user is enrolled in the course, false otherwise.
     */
    public function isEnrolled($accountId, $courseId) {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM ENROLLMENT WHERE ACCOUNTID = ? AND COURSEID = ?");
        $stmt->bind_param("ii", $accountId, $courseId); // Assuming both ACCOUNTID and COURSEID are integers
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
                
        return $count > 0;
    }

    /**
     * Retrieves a single row from the database table by its primary key.
     * @param mixed $id The primary key of the row to retrieve.
     * @return array Returns an associative array containing the row.
     */
    public function findById($id){
        $stmt = $this->connection->prepare("SELECT * FROM ENROLLMENT WHERE ENROLLMENTID = ?");
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
        $stmt = $this->connection->prepare("INSERT INTO ENROLLMENT (ACCOUNTID, COURSEID, ISMANAGER) VALUES(?,?,?)");
        $ACCOUNTID = $data['ACCOUNTID'];
        $COURSEID = $data['COURSEID'];
        $ISMANAGER = $data['ISMANAGER'];
        $stmt->bind_param("iii", $ACCOUNTID, $COURSEID, $ISMANAGER);
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
        $stmt = $this->connection->prepare("UPDATE ENROLLMENT SET ACCOUNTID = ?, COURSEID = ?, ISMANAGER = ? WHERE ENROLLMENTID = ? ");
        $ACCOUNTID = $data['ACCOUNTID'];
        $COURSEID = $data['COURSEID'];
        $ISMANAGER = $data['ISMANAGER'];
        $ENROLLMENTID = $data['ENROLLMENTID'];
        $stmt->bind_param("iiii", $ACCOUNTID, $COURSEID, $ISMANAGER, $ENROLLMENTID);
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
        $stmt = $this->connection->prepare("DELETE FROM ENROLLMENT WHERE ENROLLMENTID = ?");
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
     * Fetches all records of students that are enrolled in the specified course id that is passed in.
     * @param mixed $id The id of the desired course to find students from.
     * @return array Rerturns an associative array of students enrolled in a specific course.
     */
    public function getCourseStudents($id){
        $stmt = $this->connection->prepare("SELECT * FROM ENROLLMENT E JOIN ACCOUNT A ON E.ACCOUNTID = A.ACCOUNTID WHERE E.COURSEID = ? AND E.ISMANAGER = FALSE");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;

    }

    /**
     * Fetches all records of managers that are enrolled in the specified course id that is passed in.
     * @param mixed $id The id of the desired course to find managers from.
     * @return array Rerturns an associative array of managers enrolled in a specific course.
     */
    public function getCourseManagers($id){
        $stmt = $this->connection->prepare("SELECT * FROM ENROLLMENT E JOIN ACCOUNT A ON E.ACCOUNTID = A.ACCOUNTID WHERE E.COURSEID = ? AND E.ISMANAGER = TRUE");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function removeEnrollment(array $data){
        $stmt = $this->connection->prepare("DELETE FROM ENROLLMENT WHERE ACCOUNTID = ? AND COURSEID = ?");
        $ACCOUNTID = $data['ACCOUNTID'];
        $COURSEID = $data['COURSEID'];
        $stmt->bind_param("ii", $ACCOUNTID, $COURSEID);
        if($stmt->execute()){
            $stmt->close(); 
            return true;
        }else{
            $stmt->close(); 
            return false;
        }
    }
    
    public function getCourseManagerNotInCourse($id){
        $stmt = $this->connection->prepare("SELECT * FROM ACCOUNT A WHERE A.USERTYPE = 'COURSEMANAGER' AND A.ACCOUNTID NOT IN 
        (SELECT A.ACCOUNTID FROM ACCOUNT A JOIN ENROLLMENT E ON A.ACCOUNTID = E.ACCOUNTID WHERE E.COURSEID = ?)");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function getUsersNotInCourse($id){
        $stmt = $this->connection->prepare("SELECT * FROM ACCOUNT A WHERE A.USERTYPE = 'STUDENT' AND A.ACCOUNTID NOT IN 
        (SELECT A.ACCOUNTID FROM ACCOUNT A JOIN ENROLLMENT E ON A.ACCOUNTID = E.ACCOUNTID WHERE E.COURSEID = ? )");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }
}

?>