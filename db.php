<?php
class database 
{
    private $conn;
    private $servername;
    private $username;
    private $password;

    function __construct($servername,$username,$password)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
    }

    function get_connection()
    {
        return $this->conn;
    }

    function connect() 
    {
        $this->conn = new mysqli($this->servername,$this->username,$this->password);
        if($this->conn->connect_error) {
            return false;
        }
        return true;
    }

    function disconnect()
    {
        $this->conn->close();
    }

    function create_tables() 
    {
        if ($this->connect()) {
            $sql = 'CREATE DATABASE IF NOT EXISTS ibikers';
            if (!$this->conn->query($sql) === TRUE) {
                return false;
            }

        }
    }

    function create_database()
    {
        if ($this->connect()) {
            $sql = 'CREATE DATABASE IF NOT EXISTS ibikers';
            if (!$this->conn->query($sql) === TRUE) {
                return false;
            }

        }
    }

}
?>