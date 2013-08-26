<?php
require_once('../../includes/bootstrap.php');
include(BASE_PATH."includes/classes/UserSession.php");
use includes\classes\Admin;
use includes\classes\AdminManager;

$email = ($_REQUEST['email']);
$password = ($_REQUEST['password']);

$adminManager = new AdminManager();
$result = $adminManager->login($email, $password);

if ($result) {
    session_start();

    $admin = new Admin();
    $admin->loadByEmail($email);

    $_SESSION['user_name'] = $email;
    $_SESSION['user_id'] = $admin->get_admin_id();
    $_SESSION['user_logged_in'] = $result;
    $_SESSION['is_admin'] = true;

    // to setup the configuration
    require_once('user_session_serialization.php');

    header("Location: " . SERVER_URL . "admin/index.php");

} else {
    header("Location: " . SERVER_URL . "admin/login.php?error=Wrong username or password!");
}
?>
