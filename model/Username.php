<?php

namespace Model;

class Username {
    private $username;

    public function __construct(string $username) {
        $this->username = $username;
    }

    public function getUsername() : string {
        return $this->username;
    }
}