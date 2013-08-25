<?php

if (session_id() == "") {
    session_start();
}

if (empty($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    // did not pass the authentication, kick back to login page
    header("Location: " . SERVER_URL . "admin/login.php?error=Please login to access the content!");
}else {
    // to setup the configuration
    require_once('user_session_serialization.php');
}

?>
