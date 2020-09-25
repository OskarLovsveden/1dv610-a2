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

    public function loginUser(\Model\Credentials $credentials) {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();


        // Create connection
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        if ($this->userExists($username)) {
            $sql = "SELECT " . self::$rowUsername . ", " . self::$rowPassword . " FROM " . self::$table . " WHERE " . self::$rowUsername . " = '" . $username . "'";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row[self::$rowPassword])) {
                    return new \Model\Username($row[self::$rowUsername]);
                }
            } else {
                throw new \Exception("Wrong name or password");
            }
        } else {
            throw new \Exception("Wrong name or password");
        }
        throw new \Exception("Wrong name or password");
    }

    private function userExists(string $username): bool {
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $query = "SELECT * FROM " . self::$table . " WHERE " . self::$rowUsername . " LIKE BINARY '" . $username . "'";
        $userExists = 0;

        if ($stmt = $connection->prepare($query)) {
            $stmt->execute();
            $stmt->store_result();
            $userExists = $stmt->num_rows;
            $stmt->close();
        }


        return $userExists == 1;
    }
}