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