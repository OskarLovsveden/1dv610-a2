<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('Controller/Login.php');

require_once("View/Login.php");
require_once('View/DateTime.php');
require_once('View/Layout.php');

require_once('Model/Username.php');
require_once('Model/Password.php');
require_once('Model/User.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_All);
//ini_set('display_errors', 'On');

// Models

// try {
//     // TEMP CODE
//     $username = new \Model\Username("Oskars");
//     $password = new \Model\Password("Password");
//     $user = new \Model\User($username, $password);
    
//     //END OF TEMP CODE
// } catch (\Exception $e) {
//     echo ($e);
// }

//CREATE OBJECTS OF THE VIEWS
$loginView = new \View\Login();
$dateTimeView = new \View\DateTime();
$layoutView = new \View\Layout();

$loginController = new \Controller\Login($loginView);
$loginController->doLogin();

$layoutView->render(false, $loginView, $dateTimeView);

// DEBUG
// var_dump($_POST);