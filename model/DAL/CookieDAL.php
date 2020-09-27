<?php

namespace Model\DAL;

class CookieDAL {

    private $database;

    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $table = 'cookies';
    private static $rowUsername = 'cookieUsername';
    private static $rowPassword = 'cookiePassword';
    private static $rowBrowser = 'cookieBrowser';
    private static $userAgent = 'HTTP_USER_AGENT';

    public function __construct(Database $database) {
        $this->database = $database;
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$table . " (
            " . self::$rowUsername . " VARCHAR(30) NOT NULL UNIQUE,
            " . self::$rowPassword . " VARCHAR(60) NOT NULL,
            " . self::$rowBrowser . " LONGTEXT NOT NULL
            )";

        $connection->query($sql);
    }

    public function saveUserCookie() {
        $this->createTableIfNotExists();

        $username = $_COOKIE[self::$cookieName];
        $password = $_COOKIE[self::$cookiePassword];
        $browser = $_SERVER[self::$userAgent];

        var_dump($username);
        echo "<br/>";
        var_dump($password);
        exit;

        // Create connection
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "";

        if ($this->userCookieExists($username)) {
            $sql = $sql = "UPDATE " . self::$table . " SET " . self::$rowBrowser . "='" . $browser . "' WHERE " . self::$rowUsername . "='" . $username . "'";
        } else {
            $sql = "INSERT INTO " . self::$table . " (" . self::$rowUsername . ", " . self::$rowPassword . ", " . self::$rowBrowser . ") VALUES ('" . $username . "', '" . $password . "', '" . $browser . "')";
        }

        $connection->query($sql);
        $connection->close();
    }

    public function userCookieExists() {
        $username = $_COOKIE[self::$cookieName];
        // $password = $_COOKIE[self::$cookiePassword];

        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "SELECT * FROM " . self::$table . " WHERE " . self::$rowUsername . " LIKE BINARY '" . $username . "' LIMIT 1";

        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($result);

        $connection->close();
    }

    public function setUserCookiesAndSaveToDatabase($cookieUserName) {
        $str = rand();
        $cookiePassword = md5($str);

        setcookie(self::$cookieName, $cookieUserName, time() + (86400 * 30), "/");
        setcookie(self::$cookiePassword, $cookiePassword, time() + (86400 * 30), "/");

        $this->saveUserCookie();
    }

    public function unsetUserCookies() {
        setcookie(self::$cookieName, "", time() - 3600);
        setcookie(self::$cookiePassword, "", time() - 3600);
    }

    public function isUserCookieActive() {
        return isset($_COOKIE[self::$cookieName]);
    }
}