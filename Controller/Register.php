<?php

namespace Controller;

class Register {
    private $registerView;
    private $sessionDAL;
    private $userDAL;

    public function __construct(\View\Register $registerView, \Model\DAL\UserDAL $userDAL, \Model\DAL\SessionDAL $sessionDAL) {
        $this->registerView = $registerView;
        $this->sessionDAL = $sessionDAL;
        $this->userDAL = $userDAL;
    }

    public function doRegister() {
        if ($this->registerView->userWantsToRegister()) {
            try {
                $this->registerView->registerFormValidAndSetMessage();
                $user = $this->registerView->getUserToRegister();
                $this->userDAL->registerUser($user);
            } catch (\Exception $e) {
                $this->sessionDAL->setInputFeedbackMessage($e->getMessage());
                $this->registerView->reloadPage();
            }
        }
    }
}