<?php

namespace Model;

class UserID {
    private $userID;

    public function __construct(string $userID) {
        $this->userID = $userID;
    }

    public function getUserID() : string {
        return $this->userID;
    }
}