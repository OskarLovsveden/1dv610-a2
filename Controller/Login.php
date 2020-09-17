<?php

namespace Controller;

require_once('model/DAL/UserDAL.php');

class Login {
    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if (!$this->loginView->sessionExists()) {
            if ($this->loginView->userWantsToLogin()) {
                if ($this->loginView->loginFormValidAndSetMessage()) {
                    $credentials = $this->loginView->getLoginCredentials();
    
                    try {
                        $user = \model\DAL\UserDAL::findUserByName($credentials);
                    } catch (\Exception $e) {
                        error_log("Error when trying to find user" . $e);
                        $this->loginView->setSessionInputFeedbackMessage("Wrong name or password");
                    }
    
                    $this->loginView->saveUserInSession($credentials->getUsername());
                    $this->loginView->setSessionInputFeedbackMessage("Welcome");
                    $this->loginView->reloadPage();
                }
             }
        }
    }
    
    public function doLogout() {
        if ($this->loginView->userWantsToLogout()) {
            $this->loginView->unsetAndDestroySession();
            $this->loginView->setSessionInputFeedbackMessage("Bye bye!");
            $this->loginView->reloadPage();
        }
    }
}