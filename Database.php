<?php

class Database {

    private $servername;
    private $username;
    private $password;
    private $dbName;

    public function __construct(string $servername, string $username, string $password, string $dbName) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function tryConnection() : string {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        return "Connected successfully";
    }

    public function addUser(User $user) : string {
        $sql = "INSERT INTO Users (username, passphrase) VALUES (" . $user->getUsername() . ", . " . $user->getPassphrase() . ")";

        if ($conn->query($sql) === true) {
            return "New record created successfully";
        } else {
            return "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}