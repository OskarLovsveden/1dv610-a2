<?php

session_start();

//INCLUDE THE FILES NEEDED...
require_once('Controller/Login.php');

require_once('view/Login.php');
require_once('view/DateTime.php');
require_once('view/Layout.php');

require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/User.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_All);
//ini_set('display_errors', 'On');

// Models

// try {
//     // TEMP CODE
//     $username = new \Model\Username("Admin");
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
$loginController->doLogout();

$sessionExists = $loginView->sessionExists();
$layoutView->render($sessionExists, $loginView, $dateTimeView);

if(isset($_SERVER,$_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
    /* Sand Box */
    echo "localhost";
    var_dump($_SESSION);
}else{
    /* Production */
    echo "production";
}
