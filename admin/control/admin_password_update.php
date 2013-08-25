<?
require_once('../../includes/bootstrap.php');
use includes\classes\Admin;

$admin_id = secureRequestParameter($_REQUEST["admin_id"]);
$new_password = secureRequestParameter($_REQUEST["password"]);

$admin = new Admin();
$admin->set_admin_id($admin_id);
$result = $admin->updatePassword(md5($new_password));

if ($result){
    $response_array['status'] = 'success';
}else{
    $response_array['status'] = 'error';
}
header('Content-type: application/json');
echo json_encode($response_array);

?>
