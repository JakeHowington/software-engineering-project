<?php

require_once "AbstractDAO.php"; // add the conn_auth.php file

/**
 * A DOA Class for the Question table.
 */
class QuestionDAO extends AbstractDAO
{

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public function findAll()
    {
        $stmt = $this->connection->prepare("SELECT * FROM QUESTION");
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
        $stmt = $this->connection->prepare("SELECT * FROM QUESTION WHERE QUESTIONID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function getAllQuestionsBySurveyId($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM QUESTION WHERE SURVEYID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function getNumQuestions($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM QUESTION WHERE SURVEYID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $numQuestions = $result->num_rows; // Get the number of rows
        $stmt->close();
        return $numQuestions;
    }

    /**
     * Inserts a new row into the database table.
     * Note: if your call this method ecrypt password before calling. 
     * @param array $data An associative array containing the data to insert.
     * @return bool Returns true if the insert was successful, false otherwise.
     */
    public function insert(array $data)
    {
        $stmt = $this->connection->prepare("INSERT INTO QUESTION (SURVEYID, QUESTION, QUESTIONTYPE, QUESTIONNUM) VALUES(?,?,?,?)");
        $SURVERYID = $data['SURVEYID'];
        $QUESTION = $data['QUESTION'];
        $QUESTIONTYPE = $data['QUESTIONTYPE'];
        $QUESTIONNUM = $data['QUESTIONNUM'];
        $stmt->bind_param("issi", $SURVERYID, $QUESTION, $QUESTIONTYPE, $QUESTIONNUM);
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
        $stmt = $this->connection->prepare("UPDATE QUESTION SET SURVEYID = ?, QUESTION = ?, QUESTIONTYPE = ?, QUESTIONNUM = ? WHERE QUESTIONID = ? ");
        $SURVERYID = $data['SURVEYID'];
        $QUESTION = $data['QUESTION'];
        $QUESTIONTYPE = $data['QUESTIONTYPE'];
        $QUESTIONNUM = $data['QUESTIONNUM'];
        $QUESTIONID = $data['QUESTIONID'];
        $stmt->bind_param("issii", $SURVERYID, $QUESTION, $QUESTIONTYPE, $QUESTIONNUM, $QUESTIONID);
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
        $stmt = $this->connection->prepare("DELETE FROM QUESTION WHERE QUESTIONID = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function getOrderedSurveyQuestion($id){
        $stmt = $this->connection->prepare("SELECT * FROM QUESTION WHERE SURVEYID = ? ORDER BY QUESTIONNUM");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

}
