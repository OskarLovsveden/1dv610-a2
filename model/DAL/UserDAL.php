<?php

namespace Model\DAL;

class UserDAL {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function registerUser(\Model\User $user) {
        $this->database->createTable();

        $username = $user->getUsername();
        $password = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        // Create connection
        $connection = new \mysqli($this->database->getHostname(), $this->database->getUsername(), $this->database->getPassword(), $this->database->getDatabase());

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $sql = "INSERT INTO users (username, password)
                VALUES ('" . $username . "', '" . $password . "')";

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }

        $connection->close();
    }

    public static function findExistingUser(\Model\Credentials $credentials): \Model\User {
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