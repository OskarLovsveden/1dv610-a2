<?php

namespace Model\DAL;

class UserDAL {
    public static function findUserByName(\Model\Credentials $credentials) : \Model\User {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();
        
        // TEMP CODE "User exists"
        if ($username == "Admin" && password_verify("Password", $password)) {
            $testUserName = new \Model\Username($username);
            $testPassword = new \Model\Password($password);

            $testUser = new \Model\User($testUserName, $testPassword);
            return $testUser;
        }

        throw new \Exception("User does not exist.");
        // throw new \Exception("Wrong name or password");
    }
}