<?php

//INCLUDE THE FILES NEEDED...
require_once('view/LoginView.php');
require_once('view/RegisterView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('Database.php');

$servername = "localhost";
$username = "users";
$password = "users";
$dbName = "users";

$db = new Database($servername, $username, $password, $dbName);
$connectionString = $db->tryConnection();

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loginView = new LoginView();
$registerView = new RegisterView();
$dtv = new DateTimeView();
$lv = new LayoutView();

$lv->render(false, $loginView, $registerView, $dtv);

if (mb_strlen($connectionString) > 0) {
    // echo $connectionString;
}
