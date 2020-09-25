<?php

namespace Model\DAL;

class Database {
    private $url;
    private $dbparts;
    private $hostname;
    private $username;
    private $password;
    private $database;

    public function __construct() {
        if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            $this->hostname = "localhost";
            $this->username = "users";
            $this->password = "users";
            $this->database = "users";
        } else {
            $this->url = getenv('JAWSDB_URL');
            $this->dbparts = parse_url($this->url);

            $this->hostname = $this->dbparts['host'];
            $this->username = $this->dbparts['user'];
            $this->password = $this->dbparts['pass'];
            $this->database = ltrim($this->dbparts['path'], '/');
        }
    }

    public function createTable() {
        $connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);

        if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
        }

        $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(250) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            if ($connection->query($sql) === TRUE) {
                // echo "Table users created successfully";
            } else {
                echo "Error creating table: " . $connection->error;
            }
        }
    }

    public function getHostname() {
        return $this->hostname;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getDatabase() {
        return $this->database;
    }
}