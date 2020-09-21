<?php

namespace Model\DAL;

class SessionDAL {
    private static $sessionInputFeedbackMessage = 'Model\\DAL\\SessionDAL::sessionInputFeedbackMessage';
    private static $sessionInputUserValue = 'Model\\DAL\\SessionDAL::sessionInputUserValue';
    private static $activeUser = 'Model\\DAL\\SessionDAL::activeUser';

	private $sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = false;

    public function setInputUserValue($username) {
		$_SESSION[self::$sessionInputUserValue] = $username;
    }
    
    public function getInputUserValue() {
		return $_SESSION[self::$sessionInputUserValue];
    }

    public function isInputUserValueSet() : bool {
        return isset($_SESSION[self::$sessionInputUserValue]);
    }
    
    public function isUserSessionActive() : bool {
		if(isset($_SESSION[self::$activeUser]) && !empty($_SESSION[self::$activeUser])) {
			return true;
		}
		return false;
    }
    
    public function setUserSession(string $username) {
		$_SESSION[self::$activeUser] = $username;
    }
    
    public function unsetUserSession() {
        if (isset($_SESSION[self::$activeUser])) {
            unset($_SESSION[self::$activeUser]);
        } else {
            throw new \Exception("Requires active user session to unset it");
        }
    }

    public function setInputFeedbackMessage(string $message) {
		$_SESSION[self::$sessionInputFeedbackMessage] = $message;
		
		// Make sure the message survives the first request since it is removed in getSavedMessage
		$this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
    }
    
    public function getInputFeedbackMessage() : string {

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
}