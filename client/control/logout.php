<?php

session_start();
session_destroy();

unset($_SESSION['user_name']);
unset($_SESSION['user_logged_in']);
unset($_SESSION['is_client']);

header("Location: ../../login.php");

?>
