<?php
class Database 
{
    private $conn;
    private $servername;
    private $username;
    private $password;
    private const DB_NAME = 'ibikers';

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
    function connect_db() 
    {
        $this->conn = new mysqli($this->servername,$this->username,$this->password,Database::DB_NAME);
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
        if ($this->connect_db()) {
            $sql_utente = "CREATE TABLE IF NOT EXISTS utente (
                    username VARCHAR(50) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    password VARCHAR(20) NOT NULL,
                    PRIMARY KEY(username)
                    )";
            if (!$this->conn->query($sql_utente) === TRUE) {
                return false;
            }
            $sql_post = "CREATE TABLE IF NOT EXISTS post (
                        id INT AUTO_INCREMENT NOT NULL,
                        username VARCHAR(50) NOT NULL,
                        marca VARCHAR(40) NOT NULL,
                        modello VARCHAR(40) NOT NULL,
                        anno YEAR NOT NULL,
                        descrizione VARCHAR(255) NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY (username) REFERENCES utente(username)
                        )";
            if (!$this->conn->query($sql_post) === TRUE) {
                return false;
            }            

        } else {
            return false;
        }
        return true;
    }

    function create_database()
    {
        if ($this->connect()) {
            $sql = 'CREATE DATABASE IF NOT EXISTS ibikers;';
            if (!$this->conn->query($sql) === TRUE) {
                $this->disconnect();
                return false;
            }

            if(!$this->create_tables()) {
                $this->disconnect();
                return false;
            }

            $this->disconnect();
            return true;
        }
    }

    function check_login($username, $password) 
    {
        //0 -> login ok
        //1 -> utente non trovato
        //2 -> password sbagliata
        if ($this->connect_db()) {
            $sql = "SELECT username, password FROM utente WHERE username='$username'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['password'] == $password) {
                    $this->disconnect();
                    return 0;
                }
                else {
                    $this->disconnect();
                    return 2;
                }
            } else {
                $this->disconnect();
                return 1;
            }
        }
    }

    function register_user($username, $email, $password) 
    {
        //0 -> registrazione eseguita
        //1 -> utente gia presente
        if ($this->connect_db()) {
            try{
                $statement = $this->conn->prepare("INSERT INTO utente(username, email, password) VALUES (?,?,?)");
                $statement->bind_param("sss", $username, $email, $password);
                $statement->execute();
            }
            catch (Exception $e) {
                $statement->close();
                $this->disconnect();
                return 1;
            }
            $statement->close();
            $this->disconnect();
            return 0;
        }
    }
}


$db = new database("localhost", "root", "");
$db->create_database();
$ris = $db->check_login('pennarello', 'penna');
echo $ris . "<br>";
$insert = $db->register_user('pennarello', 'pennarello@gmail.com', 'penna');
echo 'insert: ' . $insert . '<br>';
$ris = $db->check_login('pennarello', 'penna');
echo $ris . "<br>";
?>