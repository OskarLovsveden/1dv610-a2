<?php

namespace Model\DAL;

class UserDAL {

    public function registerUser(\model\User $user) {
        // TODO register user
    }

    public static function findUserByName(\Model\Credentials $credentials): \Model\User {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();

        // TODO: fix TEMP CODE "User exists" once registration is in place
        if ($username == "Admin" && password_verify("Password", $password)) {
            $testUserName = new \Model\Username($username);
            $testPassword = new \Model\Password($password);

            $testUser = new \Model\User($testUserName, $testPassword);
            return $testUser;
        }
        // end

        throw new \Exception("Wrong name or password");
    }
}