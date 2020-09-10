<?php

namespace Model;

class User {

    private $username;
    private $password;
    private $userID;

    public function __construct(Username $username, Password $password, UserID $userID) {
        $this->username = $username;
        $this->password = $password;
        $this->userID = $userID;
    }

    public function getUsername() : Username {
        return $this->username;
    }

    public function getPassword() : Password {
        return $this->password;
    }

    public function getUserID() : UserID {
        return $this->userID;
    }
}