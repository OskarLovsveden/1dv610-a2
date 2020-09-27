<?php

namespace Model\DAL;

class CookieDAL {

    private $database;
    private $cookieUsername;
    private $cookiePassword;

    private static $cookieNameKey = 'LoginView::CookieName';
    private static $cookiePasswordKey = 'LoginView::CookiePassword';
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

        $username = $this->cookieUsername;
        $password = $this->cookiePassword;
        $browser = $_SERVER[self::$userAgent];

        // Create connection
        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "REPLACE INTO " . self::$table . " (" . self::$rowUsername . ", " . self::$rowPassword . ", " . self::$rowBrowser . ") VALUES ('" . $username . "', '" . $password . "', '" . $browser . "')";

        // if ($this->userCookieExists($username)) {
        //     $sql = "REPLACE INTO " . self::$table . " (" . self::$rowUsername . ", " . self::$rowPassword . ", " . self::$rowBrowser . ") VALUES ('" . $username . "', '" . $password . "', '" . $browser . "')";
        // } else {
        //     $sql = "INSERT INTO " . self::$table . " (" . self::$rowUsername . ", " . self::$rowPassword . ", " . self::$rowBrowser . ") VALUES ('" . $username . "', '" . $password . "', '" . $browser . "')";
        // }

        $connection->query($sql);
        $connection->close();
    }

    public function getUserCookie($username) {

        $connection = new \mysqli(
            $this->database->getHostname(),
            $this->database->getUsername(),
            $this->database->getPassword(),
            $this->database->getDatabase()
        );

        $sql = "SELECT * FROM " . self::$table . " WHERE " . self::$rowUsername . " LIKE BINARY '" . $username . "' LIMIT 1";

        $result = mysqli_query($connection, $sql);

        if ($result === false) {
            throw new \Exception("No such saved Cookie");
        }

        $row = mysqli_fetch_assoc($result);
        return $row;
        // $connection->close();
    }

    public function setUserCookies($cookieUsername) {
        $str = rand();
        $cookiePassword = md5($str);

        setcookie(self::$cookieNameKey, $cookieUsername, time() + (86400 * 30), "/");
        setcookie(self::$cookiePasswordKey, $cookiePassword, time() + (86400 * 30), "/");

        $this->cookieUsername = $cookieUsername;
        $this->cookiePassword = $cookiePassword;
    }

    public function unsetUserCookies() {
        setcookie(self::$cookieNameKey, "", time() - 3600);
        setcookie(self::$cookiePasswordKey, "", time() - 3600);
    }

    public function isUserCookieActive() {
        return isset($_COOKIE[self::$cookieNameKey]);
    }

    public function userBrowserValid() {
        $userCookie = $this->getUserCookie("Admin");
        // var_dump($userCookie["cookieBrowser"]);
        // exit;

        if ($userCookie["cookieBrowser"] === $_SERVER['HTTP_USER_AGENT']) {
            return true;
        }
        return false;
    }
}
