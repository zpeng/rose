<?php
require_once('../../includes/bootstrap.php');

use includes\classes\CallLogManager;

$csv_file = $_REQUEST['csv_file'];

$callLogManager = new CallLogManager();
$array_from_csv = readCSV($csv_file);
$callLogManager->appendNewLog($array_from_csv);

$url_ok = SERVER_URL . "admin/index.php?view=call_log_list"; // target of the redirect
$url_ok = $url_ok . "&info=Call log has been updated!";
header("Location: " . $url_ok);

?>