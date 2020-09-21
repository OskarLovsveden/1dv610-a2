<?php

namespace Controller;

require_once('model/DAL/UserDAL.php');

class Login {
    private $loginView;
    private $sessionDAL;
    private $cookieDAL;
    
    public function __construct(\View\Login $loginView, \Model\DAL\CookieDAL $cookieDAL, \Model\DAL\SessionDAL $sessionDAL) {
        $this->loginView = $loginView;
        $this->sessionDAL = $sessionDAL;
        $this->cookieDAL = $cookieDAL;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogin()) {
            if ($this->loginView->loginFormValidAndSetMessage()) {
                $credentials = $this->loginView->getLoginCredentials();

                try {
                    $user = \model\DAL\UserDAL::findUserByName($credentials);
                    
                    $this->sessionDAL->setInputFeedbackMessage("Welcome");
                    
                    if ($credentials->getKeepUserLoggedIn()) {
                        $username = $user->getUsername();
                        $password = $user->getPassword();
                        
                        $this->cookieDAL->setUserCookies($username, $password);
                    }
                
                    $this->sessionDAL->setUserSession($user->getUsername());    
                    $this->loginView->reloadPage();

                } catch (\Exception $e) {
                    error_log("Something went wrong: " . $e);
                    $this->sessionDAL->setInputFeedbackMessage("Wrong name or password");
                    $this->loginView->reloadPage();
                }
            }
         }
    }
    
    public function doLogout() {
        if ($this->loginView->userWantsToLogout()) {
            if ($this->sessionDAL->isUserSessionActive()) {
                var_dump("active session bye");
                $this->sessionDAL->unsetUserSession();
            }
            
            if ($this->cookieDAL->isUserCookieActive()) {
                var_dump("active cookie bye");
                $this->cookieDAL->unsetUserCookies();
            }

            $this->sessionDAL->setInputFeedbackMessage("Bye bye!");
            $this->loginView->reloadPage();
        }
    }
}