<?php
require_once('../../includes/bootstrap.php');
include(BASE_PATH."includes/classes/UserSession.php");
use includes\classes\Client;
use includes\classes\ClientManager;

$email = ($_REQUEST['email']);
$password = ($_REQUEST['password']);

$clientManager = new ClientManager();
$result = $clientManager->login($email, $password);

if ($result) {
    session_start();

    $client = new Client();
    $client->loadByEmail($email);

    $_SESSION['user_name'] = $email;
    $_SESSION['user_id'] = $client->getClientId();
    $_SESSION['user_logged_in'] = $result;
    $_SESSION['is_client'] = true;

    // to setup the configuration
    require_once('user_session_serialization.php');

    header("Location: " . SERVER_URL . "client/index.php");

} else {
    header("Location: " . SERVER_URL . "login.php?error=Wrong username or password!");
}
?>
