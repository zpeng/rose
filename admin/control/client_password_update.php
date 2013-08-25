<?
require_once('../../includes/bootstrap.php');
use includes\classes\Client;

$client_id = secureRequestParameter($_REQUEST["client_id"]);
$new_password = secureRequestParameter($_REQUEST["password"]);

$client = new Client();
$client->setClientId($client_id);
$result = $client->updatePassword(md5($new_password));

if ($result){
    $response_array['status'] = 'success';
}else{
    $response_array['status'] = 'error';
}
header('Content-type: application/json');
echo json_encode($response_array);

?>
