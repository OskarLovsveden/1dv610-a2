<?php

namespace Model;

class Credentials {
    private $username;
    private $password;

    public function __construct(Username $username, Password $password) {
        $this->username = $username;
        $this->password = $password;
    }
}