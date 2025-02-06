<?php

/**
 * Abstract class for managing the connection to a database.
 */
abstract class AbstractDatabaseConnection {
    protected $host     = "localhost";
    protected $username = "dev";
    protected $password = "password";
    protected $database = "NOP";

    /**
     * Establishes a connection to the database server.
     * @return mixed Returns the database connection object.
     */
    abstract public function connect();

    /**
     * Closes the database connection.
     * @return void
     */
    abstract public function disconnect();
}

/**
 * Concrete class for managing the connection to a MariaDB database.
 */
class MariaDBConnection extends AbstractDatabaseConnection {
    private static $connection; //Sort of a singleton, minimizes the number of connections

    /**
     * Establishes a connection to the MariaDB database server.
     * @return mysqli Returns the MySQLi database connection object.
     */
    public function connect() {
        #Create a new connection if it doesn't exist
        if (!self::$connection) {
            self::$connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        }

        #Check if the connection was successful
        if (self::$connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
        
        return self::$connection;
    }

    /**
     * Closes the connection to the MariaDB database.
     * @return void
     */
    public function disconnect() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

#TODO: Implement a single connection class for the as a single access point, and tie the database type to a configuration file
#Priorty: Low
class DatabaseConnection {
    private static $connection;

    public static function getConnection() {
        if (!self::$connection) {
            self::$connection = new MariaDBConnection();
        }

        return self::$connection;
    }
}

?>