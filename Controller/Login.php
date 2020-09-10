<?php

namespace Controller;

class Login {
    private $loginView;

    public function __construct(\View\Login $loginView) {
        $this->loginView = $loginView;
    }

    public function doLogin() {
        if ($this->loginView->userWantsToLogIn()) {
            if($this->loginView->loginFieldsValid()) {
                echo "allt e gött";
            }
        }
    }
}