<?php

namespace Model;

class User {

    private $username;
    private $password;

    public function __construct(\Model\Username $username, \Model\Password $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() : string {
        return $this->username->getUsername();
    }

    public function getPassword() : string {
        return $this->password->getPassword();
    }

    public function findUserByName(Credentials $credentials) : User {
        $testUsername = new \Model\Username("Admin");
        $testPassword = new \Model\Password(password_hash("Password"));
        $testUser = new \Model\User($testUser, $testPassword);
    }
}