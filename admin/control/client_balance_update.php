<?
require_once('../../includes/bootstrap.php');
use includes\classes\Client;

$client_id = secureRequestParameter($_REQUEST["client_id"]);

$client = new Client();
$client->loadByID($client_id);
$client->updateBalance();

$url = SERVER_URL . "admin/index.php?view=client_list"; // target of the redirect
$msg = "The balance for client ".$client->getEmail()." has been updated!";
$url = $url . "&info=" . $msg;

header("Location: " . $url);

?>
