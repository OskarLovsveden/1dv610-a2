<?php

class Database {

private $servername;
private $username;
private $password;

public function __construct(string $servername, string $username, string $password) {
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;
}

public function tryConnection() {
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password);
    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
    }
}