<?php

namespace View;

class Register {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';

	private $registerFormErrors = array();

	private $cookieDAL;
	private $sessionDAL;

	public function __construct(\Model\DAL\CookieDAL $cookieDAL, \Model\DAL\SessionDAL $sessionDAL) {
		$this->cookieDAL = $cookieDAL;
		$this->sessionDAL = $sessionDAL;
	}

	public function userWantsToRegister() {
		return isset($_POST[self::$register]);
	}

	public function registerFormValidAndSetMessage() {
		if (strlen($this->getRequestUserName()) < 3) {
			array_push($this->registerFormErrors, "Username has too few characters, at least 3 characters.");
		}

		if (strlen($this->getRequestPassword()) < 6) {
			array_push($this->registerFormErrors, "Password has too few characters, at least 6 characters.");
		}

		if ($this->getRequestPassword() != $this->getRequestPasswordRepeat()) {
			array_push($this->registerFormErrors, "Passwords do not match.");
		}

		if (!empty($this->registerFormErrors)) {
			$this->sessionDAL->setInputUserValue($this->getRequestUserName());
			$br_separated_errors = implode("<br>", $this->registerFormErrors);
			throw new \Exception($br_separated_errors);
		}
	}

	public function reloadPage() {
		header("Location: /?register");
	}


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = $this->sessionDAL->getInputFeedbackMessage(); // Using variable

		$usernameInputValue = "";

		if ($this->sessionDAL->isInputUserValueSet()) {
			$usernameInputValue = $this->sessionDAL->getInputUserValue();
		}

		$response = $this->generateRegisterFormHTML($message, $usernameInputValue);
		return $response;
	}

	/**
	 * Generate HTML code on the output buffer for the logout button
	 * @param $message, String output message
	 * @return  void, BUT writes to standard output!
	 */
	private function generateRegisterFormHTML($message, $usernameInputValue) {
		return '
        <h2>Register new user</h2>
        <form action="?register" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
                <p id="' . self::$messageId . '">' . $message . '</p>
                <label for="' . self::$name . '" >Username :</label>
                <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="' . $usernameInputValue . '" />
                <br/>
                <label for="' . self::$password . '" >Password  :</label>
                <input type="password" size="20" name="' . self::$password . '" id="' . self::$password . '" value="" />
                <br/>
                <label for="' . self::$passwordRepeat . '" >Repeat password  :</label>
                <input type="password" size="20" name="' . self::$passwordRepeat . '" id="' . self::$passwordRepeat . '" value="" />
                <br/>
                <input id="submit" type="submit" name="' . self::$register . '"  value="Register" />
                <br/>
            </fieldset>
        </form>';
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		return $_POST[self::$name];
	}
	private function getRequestPassword() {
		return $_POST[self::$password];
	}
	private function getRequestPasswordRepeat() {
		return $_POST[self::$passwordRepeat];
	}
}
