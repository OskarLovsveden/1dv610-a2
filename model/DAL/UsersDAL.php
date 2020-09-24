<?php

namespace Model\DAL;

class UsersDAL {
  private $servername = "";
  private $username = "";
  private $password = "";
  private $database = "";

  public function setCredentials() {
    if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
      $this->servername = "localhost";
      $this->username = "users";
      $this->password = "users";
    } else {
      /* Production */
    }
  }

  public function createDatabase() {

    $connection = new \mysqli($this->servername, $this->username, $this->password);

    if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
      if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
      }
    }

    $sql = "CREATE DATABASE IF NOT EXISTS users";

    if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
      if ($connection->query($sql) === TRUE) {
        $this->database = "users";
        // echo "Database users created successfully";
      } else {
        echo "Error creating database: " . $connection->error;
      }
    }
  }

  public function createTable() {

    $connection = new \mysqli($this->servername, $this->username, $this->password, $this->database);

    if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
      if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
      }
    }

    $sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    password VARCHAR(30) NOT NULL,
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
}