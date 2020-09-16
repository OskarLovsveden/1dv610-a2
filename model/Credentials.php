<?php

namespace Model;

class Credentials {
    private $username;
    private $password;
    private $keepMeLoggedIn;

    public function __construct(Username $username, Password $password, bool $keepMeLoggedIn) {
        $this->username = $username;
        $this->password = $password;
        $this->keepMeLoggedIn = $keepMeLoggedIn;
    }

    public function getUsername() {
        return $this->username->getUsername();
    }
    
    public function getPassword() {
        return $this->password->getPassword();
    }
    
    public function getKeepMeLoggedIn() {
        return $this->keepMeLoggedIn;
    }
}