<?php

namespace Model;

class User {

    private $username;
    private $password;

    public function __construct(Username $username, Password $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function getUsername() : string {
        return $this->username->getUsername();
    }

    public function getPassword() : string {
        return $this->password->getPassword();
    }
}