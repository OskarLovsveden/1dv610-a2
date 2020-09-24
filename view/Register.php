<?php

namespace View;

class Register {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat';
	private static $messageId = 'RegisterView::Message';


	public function userWantsToRegister() {
		# code...
	}

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = '';

		$response = $this->generateRegisterFormHTML($message);
		return $response;
	}

	/**
	 * Generate HTML code on the output buffer for the logout button
	 * @param $message, String output message
	 * @return  void, BUT writes to standard output!
	 */
	private function generateRegisterFormHTML() {
		return '
        <h2>Register new user</h2>
        <form action="?register" method="post" enctype="multipart/form-data">
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
                <p id="' . self::$messageId . '"></p>
                <label for="' . self::$name . '" >Username :</label>
                <input type="text" size="20" name="' . self::$name . '" id="' . self::$name . '" value="" />
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
		//RETURN REQUEST VARIABLE: USERNAME
	}
}