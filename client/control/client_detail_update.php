<?
require_once('../../includes/bootstrap.php');
use includes\classes\Client;

$client_id = secureRequestParameter($_REQUEST["client_id"]);
$firstname = secureRequestParameter($_REQUEST["firstname"]);
$lastname = secureRequestParameter($_REQUEST["lastname"]);
$telephone = secureRequestParameter($_REQUEST["telephone"]);
$mobile = secureRequestParameter($_REQUEST["mobile"]);
$address_1 = secureRequestParameter($_REQUEST["address_1"]);
$address_2 = secureRequestParameter($_REQUEST["address_2"]);
$postcode = secureRequestParameter($_REQUEST["postcode"]);
$city = secureRequestParameter($_REQUEST["city"]);

$client = new Client();
$client->loadByID($client_id);
$client->setFirstname($firstname);
$client->setLastname($lastname);
$client->setTelephone($telephone);
$client->setMobile($mobile);
$client->setAddress1($address_1);
$client->setAddress2($address_2);
$client->setPostcode($postcode);
$client->setCity($city);
$client->updateClientDetail();

$response_array['status'] = 'success';

header('Content-type: application/json');
echo json_encode($response_array);

?>
