<?php

namespace Model\DAL;

class UserDAL {
    private $database;

    private static $table = "users";
    private static $rowUsername = "username";
    private static $rowPassword = "password";

    public function __construct(Database $database) {
        $this->database = $database;
        $this->createTableIfNotExists();
    }

    public function createTableIfNotExists() {
        $connection = new \mysqli($this->database->getHostname(), $this->database->getUsername(), $this->database->getPassword(), $this->database->getDatabase());

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$table . " (
            " . self::$rowUsername . " VARCHAR(30) NOT NULL UNIQUE,
            " . self::$rowPassword . " VARCHAR(60) NOT NULL
            )";

        if ($connection->query($sql)) {
            // Add message
        } else {
            // Add error message
        }


        // if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
        //     if ($connection->query($sql) === TRUE) {
        //         // Success
        //     } else {
        //         echo "Error creating table: " . $connection->error;
        //     }
        // }
    }

    public function registerUser(\Model\User $user) {
        $this->createTableIfNotExists();

        $username = $user->getUsername();
        $password = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        // Create connection
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "INSERT INTO " . self::$table . " (" . self::$rowUsername . ", " . self::$rowPassword . ") VALUES ('" . $username . "', '" . $password . "')";

        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }

    public function findExistingUser(\Model\Credentials $credentials) {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();

        // Create connection
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        // Check connection
        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }

        $sql = "SELECT username, password FROM users WHERE username = '" . $username . "'";
        $result = $connection->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                return new \Model\Username($row["username"]);
            }
        } else {
            // 0 results
        }
        $connection->close();
        // end

        throw new \Exception("Wrong name or password");
    }
}