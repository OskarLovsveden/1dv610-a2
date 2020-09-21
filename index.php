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

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
//error_reporting(E_All);
//ini_set('display_errors', 'On');

// Create view objects
$loginView = new \View\Login();
$dateTimeView = new \View\DateTime();
$layoutView = new \View\Layout();

$loginController = new \Controller\Login($loginView);
$sessionExists = $loginView->sessionExists();

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

    $cookie_name = "user";
    $cookie_value = "John Doe";
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

    if(!isset($_COOKIE[$cookie_name])) {
      echo "Cookie named '" . $cookie_name . "' is not set!";
    } else {
      echo "Cookie '" . $cookie_name . "' is set!<br>";
      echo "Value is: " . $_COOKIE[$cookie_name];
    }
} else {
    /* Production */
}
