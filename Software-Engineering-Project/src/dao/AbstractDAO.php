<?php
require_once 'DatabaseConnection.php'; // add the conn_auth.php file

/**
 * Abstract class for Data Access Objects (DAOs).
 */
abstract class AbstractDAO {

    protected $connection; //To be passed in the constructor

    /**
     * Constructor for the DAO class.
     */
    public function __construct()
    {
        #Get a connection from the MariaDBConnection class
        $dbc = new DatabaseConnection();
        $mdb = $dbc->getConnection();
        $this->connection = $mdb->connect();
    }

    /**
     * Retrieves all rows from the database table.
     * @return array Returns an array of associative arays containing the rows.
     */
    public abstract function findAll();

    /**
     * Retrieves a single row from the database table by its primary key.
     * @param mixed $id The primary key of the row to retrieve.
     * @return array Returns an associative array containing the row.
     */
    public abstract function findById($id);

    /**
     * Inserts a new row into the database table.
     * @param array $data An associative array containing the data to insert.
     * @return bool Returns true if the insert was successful, false otherwise.
     */
    public abstract function insert(array $data);

    /**
     * Updates an existing row in the database table.
     * @param array $data An associative array containing the new data for the row.
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public abstract function update(array $data);

    /**
     * Deletes a row from the database table by its primary key.
     * @param mixed $id The primary key of the row to delete.
     * @return bool Returns true if the delete was successful, false otherwise.
     */
    public abstract function delete($id);
    
}

?>