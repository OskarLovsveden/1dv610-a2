<?php

session_start();

// Require Controller(s)
require_once('Controller/Login.php');

// Require View(s)
require_once('view/Login.php');
require_once('view/DateTime.php');
require_once('view/Layout.php');

// Require Model(s)
require_once('model/Username.php');
require_once('model/Password.php');
require_once('model/User.php');

// Require DAL(s)
require_once('model/DAL/CookieDAL.php');
require_once('model/DAL/SessionDAL.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_All);
//ini_set('display_errors', 'On');

// Create DAL
$cookieDAL = new \Model\DAL\CookieDAL();
$sessionDAL = new \Model\DAL\SessionDAL();

// Create view objects
$loginView = new \View\Login($cookieDAL, $sessionDAL);
$dateTimeView = new \View\DateTime();
$layoutView = new \View\Layout();

$loginController = new \Controller\Login($loginView, $cookieDAL, $sessionDAL);
$sessionExists = $sessionDAL->isUserSessionActive();

// Check for active session
if ($sessionExists) {
    $loginController->doLogout();
} else {
    $loginController->doLogin();
}

// Render view
$layoutView->render($sessionExists, $loginView, $dateTimeView);

// Check if in development or production
// if(gethostbyaddr($_SERVER["REMOTE_ADDR"]))
if (isset($_SERVER,$_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost') {
    /* Development */
    var_dump($_SESSION);
} else {
    /* Production */
}
