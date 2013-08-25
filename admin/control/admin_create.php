<?
require_once('../../includes/bootstrap.php');
use includes\classes\Admin;

$email = secureRequestParameter($_REQUEST["admin_email"]);
$password = secureRequestParameter($_REQUEST["password"]);

$admin = new Admin();

$admin->set_admin_email($email);
$admin->set_admin_password(md5($password));
$admin->insert();

$url = SERVER_URL . "admin/index.php?view=admin_list"; // target of the redirect
$msg = "Admin account for [" . $email . "] has been created";
$url = $url . "&info=" . $msg;

header("Location: " . $url);

?>
