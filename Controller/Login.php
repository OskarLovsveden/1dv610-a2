<?php

namespace Controller;

require_once('model/DAL/UserDAL.php');

class Login {
    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogIn()) {
            if ($this->loginView->loginFormValidAndSetMessage()) {
                $credentials = $this->loginView->getLoginCredentials();
                try {
                    $user = \model\DAL\UserDAL::findUserByName($credentials);
                    if($credentials->getKeepUserLoggedIn()) {
                        $this->loginView->keepUserLoggedInSession($credentials->getUsername());
                    }
                } catch (\Exception $e) {
                    $this->loginView->setLoginFailedMessage("Wrong name or password");
                    error_log("Error when loading data" . $e);
                }
            }
        }
    }
}