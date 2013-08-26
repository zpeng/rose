<?
require_once('../../includes/bootstrap.php');

use includes\classes\RateManager;
use includes\classes\PaymentManager;
use includes\classes\CallLogManager;

if (!empty($_REQUEST['operation_id'])) {
    switch ($_REQUEST['operation_id']) {


        case "fetch_rate_table":
            $client_id  = $_REQUEST['client_id'];
            $rateManager = new RateManager();
            $data = $rateManager->getClientRateTableDataSource($client_id);
            break;

        case "fetch_payment_table":
            $client_id  = $_REQUEST['client_id'];
            $start  = $_REQUEST['start'];
            $end  = $_REQUEST['end'];
            $paymentManager = new PaymentManager();
            $data = $paymentManager->getClientPaymentTableDataSource($start, $end, $client_id);
            break;

        case "fetch_call_log_table":
            $client_id  = $_REQUEST['client_id'];
            $start  = $_REQUEST['start'];
            $end  = $_REQUEST['end'];
            $callLogManager = new CallLogManager();
            $data = $callLogManager->getClientCallLogTableDataSource($start, $end, $client_id);
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