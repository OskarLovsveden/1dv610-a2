<?php

namespace Model\DAL;

class SessionDAL {
  private static $sessionInputFeedbackMessage = 'Model\\DAL\\SessionDAL::sessionInputFeedbackMessage';
  private static $sessionInputUserValue = 'Model\\DAL\\SessionDAL::sessionInputUserValue';
  private static $userBrowser = 'Model\\DAL\\SessionDAL::userBrowser';
  private static $activeUser = 'Model\\DAL\\SessionDAL::activeUser';

  private $sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = false;

  // public function startSession() {
  //   session_start();
  //   if ($this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest) {
  //     $_SESSION[self::$sessionInputFeedbackMessage] = array();
  //   }
  // }

  public function setInputUserValue($username) {
    $_SESSION[self::$sessionInputUserValue] = $username;
  }

  public function getInputUserValue() {
    return $_SESSION[self::$sessionInputUserValue];
  }

  public function isInputUserValueSet(): bool {
    return isset($_SESSION[self::$sessionInputUserValue]);
  }

  public function isUserSessionActive(): bool {
    if (isset($_SESSION[self::$activeUser]) && !empty($_SESSION[self::$activeUser])) {
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
      throw new \Exception("Requires activeUser session to unset it");
    }
  }

  public function setInputFeedbackMessage(string $message) {
    $_SESSION[self::$sessionInputFeedbackMessage] = $message; //Using variable

    // Using array
    // $messageArray = array();
    // $messageArray = $_SESSION[self::$sessionInputFeedbackMessage];
    // array_push($messageArray, $message);
    // $_SESSION[self::$sessionInputFeedbackMessage] = $messageArray;

    // Make sure the message survives the first request since it is removed in getInputFeedbackMessage
    $this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest = true;
  }

  public function unsetInputFeedbackMessage() {
    if (isset($_SESSION[self::$sessionInputFeedbackMessage])) {
      unset($_SESSION[self::$sessionInputFeedbackMessage]); // Using variable
      // $_SESSION[self::$sessionInputFeedbackMessage] = array(); // Using array
    } else {
      throw new \Exception("Requires InputFeedbackMessage session to unset it");
    }
  }

  public function getInputFeedbackMessage() {
    if ($this->sessionInputFeedbackMessageWasSetAndShouldNotBeRemovedDuringThisRequest) {
      return $_SESSION[self::$sessionInputFeedbackMessage];
    }

    if (isset($_SESSION[self::$sessionInputFeedbackMessage])) {
      $message = $_SESSION[self::$sessionInputFeedbackMessage];
      $this->unsetInputFeedbackMessage();

      return $message;
    }
    return "";
  }

  // public function setUserBrowser() {
  //   $_SESSION[self::$userBrowser] = $_SERVER['HTTP_USER_AGENT'];
  // }

  // public function userBrowserValid(): bool {
  //   if ($_SESSION[self::$userBrowser] === $_SERVER['HTTP_USER_AGENT']) {
  //     return true;
  //   }
  //   return false;
  // }
}
