<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../src/Functions.php';

$userstr = 'Welcome Guest';
$randstr = substr(md5(rand()), 0, 7);

if(isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "Logged in as: $user";
} else {
    $loggedin = FALSE;
}

echo <<<_INIT
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='assets/css/styles.css'>
<script src='assets/js/bundle.js' defer></script>
<title>Stefano's Hood: $userstr</title>
</head>
<body>
    <div data-role='page'>
        <div data-role='header'>
            <div id='logo' class='center'>S<img id='cappuccino' src='/uploads/cappuccino.gif' alt='Cappuccino'>fano's Hood</div>
            <div class='username'>$userstr</div>
        </div>
        <div data-role='content'>
_INIT;

if($loggedin) {
    echo <<<_LOGGEDIN
        <div class='center'>
        <a data-role='button' data-inline='true' data-icon='home' data-transition="slide" href='members.php?view=$user&r=$randstr'>Home</a>
        <a data-role='button' data-inline='true' data-icon='user' data-transition="slide" href='members.php?r=$randstr'>Members</a>
        <a data-role='button' data-inline='true' data-icon='heart' data-transition="slide" href='friends.php?r=$randstr'>Friends</a>
        <a data-role='button' data-inline='true' data-icon='mail' data-transition="slide" href='messages.php?r=$randstr'>Messages</a>
        <a data-role='button' data-inline='true' data-icon='edit' data-transition="slide" href='profile.php?r=$randstr'>Edit Profile</a>
        <a data-role='button' data-inline='true' data-icon='action' data-transition="slide" href='logout.php?r=$randstr'>Log out</a>
        </div>
    _LOGGEDIN;
} else {
    echo <<<_GUEST
    <div class='center'>
    <a data-role='button' data-inline='true' data-icon='home' data-transition="slide" href='index.php?r=$randstr'>Home</a>
    <a data-role='button' data-inline='true' data-icon='plus' data-transition="slide" href='signup.php?r=$randstr'>Sign up</a>
    <a data-role='button' data-inline='true' data-icon='check' data-transition="slide" href='login.php?r=$randstr'>Log in</a>
    </div>
    <p class='info'>(You must be logged in to use this app)</p>
    _GUEST;
}
?>