<?php
require_once('../../includes/bootstrap.php');
use includes\classes\CallLogManager;

$client_id = $_REQUEST["client_id"];
$start  = $_REQUEST['start'];
$end  = $_REQUEST['end'];

$callManager = new CallLogManager();
//echo $callManager->getClientCallLogPrintingContent($start, $end, $client_id);

// LOAD a stylesheet
$stylesheet = file_get_contents(BASE_PATH . "css/call_log_style.css");

$mpdf=new mPDF();
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($callManager->getClientCallLogPrintingContent($start, $end, $client_id));
$mpdf->Output();
exit;


?>