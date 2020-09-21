<?php

namespace Model\DAL;

class CookieDAL {

    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

    public function setUserCookies($cookieUserName, $cookieUserPassword) {
		setcookie(self::$cookieName, $cookieUserName, time() + (86400 * 30), "/");
		setcookie(self::$cookiePassword, "cookieSecret", time() + (86400 * 30), "/");
    }

    public function unsetUserCookies() {
        setcookie(self::$cookieName, "", time() - 3600);
        setcookie(self::$cookiePassword, "", time() - 3600);
    }

    public function isUserCookieActive() {
        return isset($_COOKIE[self::$cookieName]);
    }
}