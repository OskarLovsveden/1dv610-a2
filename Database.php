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

public function tryConnection() {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    }
}