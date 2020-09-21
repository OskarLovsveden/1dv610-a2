<?php

namespace View;

class Register {
	private static $register = 'RegisterView::Register';
	private static $name = 'RegisterView::UserName';
	private static $password = 'RegisterView::Password';
	private static $repeatPassword = 'RegisterView::RepeatPassword';
	private static $messageId = 'RegisterView::Message';

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
	private function generateRegisterFormHTML($message) {
		return '
		<form method="post" > 
		<fieldset>
		<legend>Register a new user - Write username and password</legend>
		<p id="' . self::$messageId . '">' . $message . '</p>
		
		<label for="' . self::$name . '">Username :</label>
		<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />
		</br>

		<label for="' . self::$password . '">Password :</label>
		<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
		</br>

		<label for="' . self::$repeatPassword . '">Repeat password :</label>
		<input type="repeatPassword" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />
		</br>
		
		<input type="submit" name="' . self::$register . '" value="Register" />
		</fieldset>
		</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}
}