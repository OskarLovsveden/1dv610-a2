<?php

namespace View;

require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/Credentials.php');

class Login {

	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';

	private static $sessionInputFeedbackMessage = 'View\\Login::sessionInputFeedbackMessage';
	private static $sessionInputUserValue = 'View\\Login::sessionInputUserValue';
	private $sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = false;

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response(bool $isLoggedIn) : string {
		$message = $this->getSessionInputFeedbackMessage();
		$response = "";

		if ($isLoggedIn) {
			$response .= $this->generateLogoutButtonHTML($message);
		} else {
			$usernameInputValue = "";

			if (isset($_SESSION[self::$sessionInputUserValue])) {
				$usernameInputValue = $_SESSION[self::$sessionInputUserValue];
			}

			$response .= $this->generateLoginFormHTML($message, $usernameInputValue);
		}
		return $response;
	}

	public function userWantsToLogin() : bool {
		return isset($_POST[self::$login]);
	}
	
	public function loginFormValidAndSetMessage() : bool {
		if (!$this->getRequestUserName()) {
			$this->setSessionInputFeedbackMessage("Username is missing");
			return false;
		} else if (!$this->getRequestPassword()) {
			$this->setSessionInputFeedbackMessage("Password is missing");
			$this->setSessionInputUserValue();
			return false;
		}
		return true;
	}

	public function setSessionInputUserValue() {
		$_SESSION[self::$sessionInputUserValue] = $this->getRequestUserName();
	}
	
	public function getLoginCredentials() : \Model\Credentials {
		$username = new \Model\Username($this->getRequestUserName());
		$password = new \Model\Password(password_hash($this->getRequestPassword(), PASSWORD_BCRYPT));
		$keepMeLoggedIn = $this->getRequestKeepMeLoggedIn();
		
		$credentials = new \Model\Credentials($username, $password, $keepMeLoggedIn);
		return $credentials;
	}
	
	public function setSessionInputFeedbackMessage(string $message) {
		$_SESSION[self::$sessionInputFeedbackMessage] = $message;
		
		// Make sure the message survives the first request since it is removed in getSavedMessage
		$this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
	}
	
	public function saveUserInSession(string $username) {
		$_SESSION[self::$name] = $username;
	}
	
	public function keepUserLoggedIn() {
		// To set a Cookie
		// You could use the array to store several user info in one cookie
		$cookie_name = "user";
		$cookie_value = "John Doe";
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	
		if(!isset($_COOKIE[$cookie_name])) {
		  echo "Cookie named '" . $cookie_name . "' is not set!";
		} else {
		  echo "Cookie '" . $cookie_name . "' is set!<br>";
		  echo "Value is: " . $_COOKIE[$cookie_name];
		}
		
		// Now to log off, just set the cookie to blank and as already expired
	}
	
	public function sessionExists() : bool {
		if(isset($_SESSION[self::$name]) && !empty($_SESSION[self::$name])) {
			return true;
		}
		return false;
	}
	
	public function userWantsToLogout() : bool {
		return isset($_POST[self::$logout]);
	}

	public function unsetAndDestroySession() {
		if (isset($_SESSION[self::$name])) {
            unset($_SESSION[self::$name]);
		} else {
			throw new \Exception("Requires active session to unset it");
		}
	}

	public function reloadPage() {
		header("Location: /");
	}

	private function getSessionInputFeedbackMessage() : string {

        if($this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest) {
            return $_SESSION[self::$sessionInputFeedbackMessage];
        }

        if (isset($_SESSION[self::$sessionInputFeedbackMessage])) {
            $message = $_SESSION[self::$sessionInputFeedbackMessage];
            unset($_SESSION[self::$sessionInputFeedbackMessage]);

            return $message;
        }
        return "";
    }

	/**
	 * Generate HTML code on the output buffer for the logout button
	 * @param $message, String output message
	 * @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
		<form  method="post" >
		<p id="' . self::$messageId . '">' . $message .'</p>
		<input type="submit" name="' . self::$logout . '" value="logout"/>
		</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message, $usernameInputValue) {
		return '
		<form method="post" > 
		<fieldset>
		<legend>Login - enter Username and password</legend>
		<p id="' . self::$messageId . '">' . $message . '</p>
		
		<label for="' . self::$name . '">Username :</label>
		<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $usernameInputValue . '" />

		<label for="' . self::$password . '">Password :</label>
		<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

		<label for="' . self::$keep . '">Keep me logged in  :</label>
		<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
		
		<input type="submit" name="' . self::$login . '" value="Login" />
		</fieldset>
		</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		return $_POST[self::$name];
	}

	private function getRequestPassword() {
		return $_POST[self::$password];
	}

	private function getRequestKeepMeLoggedIn() {
		return isset($_POST[self::$keep]);
	}
}