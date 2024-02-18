<?php
class Database 
{
    private $conn;
    private $servername;
    private $username;
    private $password;
    const DB_NAME = 'ibikers';

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
                    password VARCHAR(255) NOT NULL,
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
                        descrizione TEXT NOT NULL,
                        image_path VARCHAR(100) NOT NULL,
                        PRIMARY KEY(id),
                        FOREIGN KEY (username) REFERENCES utente(username)
                        )";
            if (!$this->conn->query($sql_post) === TRUE) {
                return false;
            }     
            $sql_utente = "CREATE TABLE IF NOT EXISTS password_reset_tokens (
                username VARCHAR(50) NOT NULL,
                token VARCHAR(255) NOT NULL,
                expires_at DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(username, token),
                FOREIGN KEY (username) REFERENCES utente(username)
                )";
            if (!$this->conn->query($sql_utente) === TRUE) {
                return false;
            }       

        } else {
            return false;
        }
        return true;
    }

    function create_database()
    {
        //-1 -> errore nella connessione
        //0 -> tutto apposto
        //1 -> errore nella creazione del database
        //2 -> errore nella creazione delle tabelle
        if ($this->connect()) {
            $sql = 'CREATE DATABASE IF NOT EXISTS ibikers;';
            if (!$this->conn->query($sql) === TRUE) {
                $this->disconnect();
                return 1;
            }

            if(!$this->create_tables()) {
                $this->disconnect();
                return 2;
            }

            $this->disconnect();
            return 0;
        } 
        else {
            return -1;
        }
    }

    function check_login($username, $password)
    {
        //-1 -> errore nella connessione
        //0 -> login ok
        //1 -> utente non trovato
        //2 -> password sbagliata
        if ($this->connect_db()) {
            $sql = "SELECT username, password FROM utente WHERE username='$username'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
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
        else {
            return -1;
        }
    }

    function get_email($username)
    {
        //-1 -> errore nella connessione
        //email -> ok
        //1 -> utente non trovato
        if ($this->connect_db()) {
            $sql = "SELECT email FROM utente WHERE username = '$username'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $this->disconnect();
                return $email;
            } 
            else {
                $this->disconnect();
                return 1;
            }
        }
        else {
            $this->disconnect();
            return -1;
        }
    }

    function register_user($username, $email, $password)
    {
        //-1 -> errore nella connessione
        //0 -> registrazione eseguita
        //1 -> utente gia presente
        if ($this->connect_db()) {
            try{
                $statement = $this->conn->prepare('INSERT INTO utente(username, email, password) VALUES (?,?,?)');
                $statement->bind_param('sss', $username, $email, $password);
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
        else {
            return -1;
        }
    }

    function modify_password($username, $password)
    {
        //-1 -> errore nella connessione
        //0 -> inserimento eseguito
        //1 -> errore nell'inserimento
        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('UPDATE utente SET password = ? WHERE username = ?');
                $statement->bind_param('ss', $password, $username);
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
        else {
            return -1;
        }
    }

    function insert_post($username, $marca, $modello, $anno, $descrizione, $image_path)
    {
        //-1 -> errore nella connessione
        //0 -> inserimento eseguito
        //1 -> errore nell'inserimento
        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('INSERT INTO post(username, marca, modello, anno, descrizione, image_path) VALUES (?,?,?,?,?,?)');
                $statement->bind_param('ssssss', $username, $marca, $modello, $anno, $descrizione, $image_path);
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
        else {
            return -1;
        }
    }

    function get_all_posts() {
        //se ritorna $posts -> ci sono risultati
        //-1 -> nessuna connessione
        //1 -> 0 dati
        if ($this->connect_db()) {
            $sql = "SELECT * FROM post";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $posts = $result->fetch_all(MYSQLI_ASSOC);
                $this->disconnect();
                return $posts;
            }
            else {
                $this->disconnect();
                return 1;
            }
        }
        else {
            return -1;
        }
    }

    function edit_post($id, $marca, $modello, $anno, $descrizione)
    {
        //-1 -> errore nella connessione
        //0 -> update andato a buon fine
        //1 -> update non riuscito
        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('UPDATE post SET marca = ?, modello = ?, anno = ?, descrizione = ? WHERE id = ?');
                $statement->bind_param('ssssi', $marca, $modello, $anno, $descrizione, $id);
                $statement->execute();
            }
            catch (Exception $e) {
                $statement->close();
                $this->disconnect();
                return 1;
            }

            if ($statement->affected_rows > 0) {
                $statement->close();
                $this->disconnect();
                return 0;
            }
            else {
                $statement->close();
                $this->disconnect();
                return 1;
            }
        }
        else {
            return -1;
        }

    }

    function delete_post($id)
    {
        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('DELETE FROM post WHERE id = ?');
                $statement->bind_param('i', $id);
                $statement->execute();
            }
            catch (Exception $e) {
                $statement->close();
                $this->disconnect();
                return 1;
            }

            if ($statement->affected_rows > 0) {
                $statement->close();
                $this->disconnect();
                return 0;
            }
            else {
                $statement->close();
                $this->disconnect();
                return 1;
            }
        }
        else {
            return -1;
        }
    }

    function insert_token($username, $token)
    {
        //-1 -> errore nella connessione
        //0 -> inserimento eseguito
        //1 -> errore nell'inserimento
        $expirationTime = new DateTime();
        $expirationTime->modify('+15 minutes');
        $expirationTimeString = $expirationTime->format('Y-m-d H:i:s');

        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('INSERT INTO password_reset_tokens (username, token, expires_at) VALUES (?, ?, ?)');
                $statement->bind_param('sss', $username, $token, $expirationTimeString);
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
        else {
            return -1;
        }
    }

    function check_token_isvalid($username, $token)
    {
        //-1 -> connessione fallita
        //0 -> token valido
        //1 -> errore
        $result = '';
        if ($this->connect_db()) {
            try {
                $statement = $this->conn->prepare('SELECT * FROM password_reset_tokens WHERE token = ? AND username = ? AND expires_at > NOW()');
                $statement->bind_param('ss', $token, $username);
                $statement->execute();
                $result = $statement->get_result();
            }
            catch (Exception $e) {
                $statement->close();
                $this->disconnect();
                return 1;
            }

            if ($result->num_rows === 1) {
                $statement->close();
                $this->disconnect();
                return 0;
            } 
            else {
                $statement->close();
                $this->disconnect();
                return 1;
            }
        }
        else {
            return -1;
        }
    }
}


$db = new database("localhost", "root", "");
$db->create_database();

//$deleted = $db->delete_post(2);
//echo $deleted;

//$ciccio_update = $db->edit_post(2, 'ducati', 'panigale v2 carbon fiba', '2020', "E' UNA BOMBAAZZAAAAAAAAAAAAA!!");
//echo $ciccio_update;

/*$pasticcios = $db->get_all_posts();
foreach ($pasticcios as $pasticcio) {
    if (isset($pasticcio)) {
        echo 'id: ' . $pasticcio['id'];
        echo '<br>';
    }
}*/

//$ciccio = $db->insert_post('admin', 'ktm', 'exc 300 2t', '2023', "URTAAAAAAAAA");
//echo $ciccio;

//$ris = $db->check_login('pennarello', 'penna');
//echo $ris . "<br>";

//$insert = $db->register_user('pennarello', 'pennarello@gmail.com', 'penna');
//echo 'insert: ' . $insert . '<br>';

//$ris = $db->check_login('pennarello', 'penna');
//echo $ris . "<br>";
