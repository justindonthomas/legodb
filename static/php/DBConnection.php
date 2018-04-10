<?php
/**
 * A wrapper for a mysqli object that allows the us
 */
class DBConnection
{
    private $dbConnection;

    public function __construct(string $host, string $uname, string $pword, string $dbname) {
        $this->dbConnection = new mysqli($host,$uname,$pword,$dbname);
        if ($this->dbConnection->connect_errno) {
            echo "Unable to connect: ".$this->dbConnection->connect_error;
        }
    }

    /**
     * Execute a query given only a query string.
     * @param string $queryString Sql query string to run.
     * @return bool|mysqli_result Results or a false on failure.
     */
    public function executeSimpleQuery(string $queryString) {
        return $this->dbConnection->query($queryString);
    }

    /**
     * Execute a mysql query with supplied parameters and bound results.
     * @param string $queryString sql query string set to take supplied parameters.
     * @param string $types the parameter types to be supplied.
     * @param array $vars An array object of supplied parameters.
     * @param array ...$results A vararg. Variables to bind results to.
     * @return mysqli_stmt
     */
    public function executePreparedSelect(string $queryString, string $types, array $vars, &...$results) {

        foreach($vars as $var) {
            $var = $this->dbConnection->real_escape_string($var);
        }

        $sqlStatement = $this->dbConnection->prepare($queryString);
        if($sqlStatement === false) {
            echo $sqlStatement->error;
        } else {
            if (!$sqlStatement->bind_param($types, ...$vars)) {
                echo 'Unable to bind_param: '. $sqlStatement->errno . ":" .$sqlStatement->error."<br>";
            }
            $sqlStatement->execute();
            $sqlStatement->store_result();
            $sqlStatement->bind_result(...$results);
        }
        return $sqlStatement;
    }

    /**
     * Execute a prepared statement without bound results.
     * TODO error handling.
     * @param string $queryString
     * @param string $types
     * @param array ...$vars
     * @return mysqli_stmt
     */
    public function executePreparedStatement(string $queryString, string $types, ...$vars) {
        foreach($vars as $var) {
            $var = $this->dbConnection->real_escape_string($var);
        }
        $sqlStatement = $this->dbConnection->prepare($queryString);
        $sqlStatement->bind_param($types, ...$vars);
        $sqlStatement->execute();
        return $sqlStatement;
    }

    /**
     * Get errno for the latest query.
     * @return int errno.
     */
    public function getErrno() {
        return $this->dbConnection->errno;
    }

    /**
     * Get the error message for the latest query.
     * @return string Error message.
     */
    public function getError() {
        return $this->dbConnection->error;
    }

}