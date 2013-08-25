<?
require_once('../../includes/bootstrap.php');
use includes\classes\Client;

$client_id = secureRequestParameter($_REQUEST["client_id"]);
$email = secureRequestParameter($_REQUEST["email"]);
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
$status = secureRequestParameter($_REQUEST["status"]);

$client = new Client();
$client->setClientId($client_id);
$client->setEmail($email);
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
$client->setActive($status);
$client->updateClientDetail();

$response_array['status'] = 'success';

header('Content-type: application/json');
echo json_encode($response_array);

?>
