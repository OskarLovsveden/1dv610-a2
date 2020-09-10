<?php

//INCLUDE THE FILES NEEDED...
require_once('Controller/Login.php');

require_once('View/Login.php');
require_once('View/Register.php');
require_once('View/DateTime.php');
require_once('View/Layout.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_All);
//ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loginView = new \View\Login();
$registerView = new \View\Register();
$dateTimeView = new \View\DateTime();
$layoutView = new \View\Layout();

$loginController = new \Controller\Login($loginView);
$loginController->doLogin();

$layoutView->render(false, $loginView, $registerView, $dateTimeView);

// DEBUG
// var_dump($_POST);