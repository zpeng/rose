<?
require_once('../../includes/bootstrap.php');

use includes\classes\AdminManager;
use includes\classes\ClientManager;
use includes\classes\RateManager;

if (!empty($_REQUEST['operation_id'])) {
    switch ($_REQUEST['operation_id']) {

        case "fetch_admin_table":
            $is_active = $_REQUEST['is_active'];
            $adminManager = new AdminManager();
            $data = $adminManager->getAdminTableDataSource($is_active);
            break;

        case "fetch_client_table":
            $is_active = $_REQUEST['is_active'];
            $clientManager = new ClientManager();
            $data = $clientManager->getClientTableDataSource($is_active);
            break;


        case "fetch_rate_table":
            $rateManager = new RateManager();
            $data = $rateManager->getAdminRateTableDataSource();
            break;

        default:
            $response_array['error_code'] = '1';
            $response_array['msg'] = "there is no matching operation id";
            break;
    }

    header('Content-type: application/json');
    echo json_encode($data);
}
?>