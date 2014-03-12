<?php

/**
 * Description of DatabaseEntity
 *
 * @author suyash
 */
class DatabaseEntity
{

    private $host;
    private $database;
    private $username;
    private $password;

    public function __construct($host, $database, $username, $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getDatabase()
    {
        return $this->database;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getConnectionParamaters()
    {
        $connectionParameters = array();
        $connectionParameters['host'] = $this->getHost();
        $connectionParameters['username'] = $this->getUsername();
        $connectionParameters['password'] = $this->getPassword();
        $connectionParameters['database'] = $this->getDatabase();

        return $connectionParameters;
    }

}

?>
