<?
require_once('../../includes/bootstrap.php');
use includes\classes\Client;

$email = secureRequestParameter($_REQUEST["email"]);
$password = secureRequestParameter($_REQUEST["password"]);
$firstname = secureRequestParameter($_REQUEST["firstname"]);
$lastname = secureRequestParameter($_REQUEST["lastname"]);
$telephone = secureRequestParameter($_REQUEST["telephone"]);
$mobile = secureRequestParameter($_REQUEST["mobile"]);
$address_1 = secureRequestParameter($_REQUEST["address_1"]);
$address_2 = secureRequestParameter($_REQUEST["address_2"]);
$postcode = secureRequestParameter($_REQUEST["postcode"]);
$city = secureRequestParameter($_REQUEST["city"]);
$country = secureRequestParameter($_REQUEST["country"]);
$currency = secureRequestParameter($_REQUEST["currency"]);
$margin = secureRequestParameter($_REQUEST["margin"]);

$client = new Client();

$client->setEmail($email);
$client->setPassword(md5($password));
$client->setFirstname($firstname);
$client->setLastname($lastname);
$client->setTelephone($telephone);
$client->setMobile($mobile);
$client->setAddress1($address_1);
$client->setAddress2($address_2);
$client->setPostcode($postcode);
$client->setCity($city);
$client->setCountry($country);
$client->setCurrency($currency);
$client->setMargin($margin);

$client->insert();

$url = SERVER_URL . "admin/index.php?view=client_list"; // target of the redirect
$msg = "Client account for [" . $email . "] has been created";
$url = $url . "&info=" . $msg;

header("Location: " . $url);

?>
