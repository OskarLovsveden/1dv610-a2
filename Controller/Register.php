<?php

namespace Controller;

class Register {
    private $registerView;
    private $sessionDAL;
    private $cookieDAL;

    public function __construct(\View\Register $registerView, \Model\DAL\CookieDAL $cookieDAL, \Model\DAL\SessionDAL $sessionDAL) {
        $this->registerView = $registerView;
        $this->sessionDAL = $sessionDAL;
        $this->cookieDAL = $cookieDAL;
    }

    public function doRegister() {
        if ($this->registerView->userWantsToRegister()) {
            try {
                $this->registerView->registerFormValidAndSetMessage();
            } catch (\Exception $e) {
                $this->sessionDAL->setInputFeedbackMessage($e->getMessage());
                $this->registerView->reloadPage();
            }
        }
    }
}
