<?php

session_start();
session_destroy();

unset($_SESSION['user_name']);
unset($_SESSION['user_logged_in']);

header("Location: ../login.php");

?>
