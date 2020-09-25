<?php

namespace Model\DAL;

class UserDAL {
    private $database;

    public function __construct(Database $database) {
        $this->database = $database;
    }

    public function createTableIfNotExists() {
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
        }

        $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(250) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if (isset($_SERVER, $_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
            if ($connection->query($sql) === TRUE) {
                return true;
            } else {
                echo "Error creating table: " . $connection->error;
                return false;
            }
        }
    }

    public function registerUser(\Model\User $user) {
        if ($this->createTableIfNotExists()) {

            $username = $user->getUsername();
            $password = password_hash($user->getPassword(), PASSWORD_BCRYPT);

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

            $sql = "INSERT INTO users (username, password)
                VALUES ('" . $username . "', '" . $password . "')";

            if ($connection->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $connection->error;
            }

            $connection->close();
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