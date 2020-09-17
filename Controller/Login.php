<?php

namespace Controller;

require_once('model/DAL/UserDAL.php');

class Login {
    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogin()) {
            if ($this->loginView->loginFormValidAndSetMessage()) {
                $credentials = $this->loginView->getLoginCredentials();
                try {
                    $user = \model\DAL\UserDAL::findUserByName($credentials);
                    $this->loginView->saveUserInSession($credentials->getUsername());
                    $this->loginView->setInputFeedbackMessage("Welcome");
                } catch (\Exception $e) {
                    $this->loginView->setInputFeedbackMessage("Wrong name or password");
                    error_log("Error when loading data" . $e);
                }
            }
        }
    }

    public function doLogout() {
        if ($this->loginView->userWantsToLogout()) {
            $this->loginView->unsetAndDestroySession();
            $this->loginView->setInputFeedbackMessage("Bye bye!");
        }
    }
}