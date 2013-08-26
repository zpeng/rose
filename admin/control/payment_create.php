<?
require_once('../../includes/bootstrap.php');
use includes\classes\Payment;
use includes\classes\Client;

$client_id = secureRequestParameter($_REQUEST["client_dropdown"]);
$payment_method = secureRequestParameter($_REQUEST["payment_method"]);
$amount = secureRequestParameter($_REQUEST["amount"]);
$remark = secureRequestParameter($_REQUEST["remark"]);

$client = new Client();
$client->loadByID($client_id);

// insert the payment
$payment = new Payment();
$payment->setClientId($client_id);
$payment->setAmount($amount);
$payment->setActualCost(floatval($amount) * (1 - floatval($client->getMargin())));
$payment->setPaymentMethod($payment_method);
$payment->setRemark($remark);
$payment->insert();

//now update the balance

$client->setBalance($client->getBalance() + $amount);
$client->updateBalance($client->getBalance());

$url = SERVER_URL . "admin/index.php?view=payment_list"; // target of the redirect
$msg = "Payment has been recorded!";
$url = $url . "&info=" . $msg;

header("Location: " . $url);

?>