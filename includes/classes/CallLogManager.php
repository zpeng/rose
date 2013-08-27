<?php
namespace includes\classes;

use includes\classes\CallLog;
use includes\classes\Client;

class CallLogManager
{

    private function loadCallLogList($start = "", $end = "", $client_id = 0)
    {
        $call_log_list = array();
        $link = getConnection();
        $query = "  SELECT    log_id,
                              call_log.client_id,
                              CONCAT(client.firstname , ' ', client.lastname) AS client_name,
                              call_number,
                              timestamp,
                              duration,
                              base_rate,
                              charge
                     FROM  call_log, client
                     WHERE client.client_id = call_log.client_id
                     AND   timestamp >= '" . $start . "'
                     AND   timestamp <= '" . $end . "' ";
        if ($client_id != 0) {
            $query = $query . "AND call_log.client_id = " . $client_id;
        }
        $query = $query . " ORDER BY timestamp DESC";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $callLog = new CallLog();
            $callLog->setLogId($newArray['log_id']);
            $callLog->setClientId($newArray['client_id']);
            $callLog->setClientName($newArray['client_name']);
            $callLog->setCallNumber($newArray['call_number']);
            $callLog->setStartTimestamp($newArray['timestamp']);
            $callLog->setDuration($newArray['duration']);
            $callLog->setBaseRate($newArray['base_rate']);
            $callLog->setCharge($newArray['charge']);
            array_push($call_log_list, $callLog);
        }
        return $call_log_list;
    }

    public function appendNewLog($array_from_csv = array(), $client_id)
    {
        $client = new Client();
        $client->loadByID($client_id);
        $margin = floatval($client->getMargin());
        $charge = 0;

        if (!is_null($array_from_csv) && sizeof($array_from_csv) > 0) {
            //build up insert query
            $query = "INSERT INTO call_log (client_id, timestamp, call_number, duration, base_rate, charge) VALUES ";
            foreach ($array_from_csv as $data) {
                if (trim($data[0]) != "") {
                    $query = $query . "(" . $client_id
                        . ",\"" . trim($data[0]) . "\""
                        . ",\"" . trim($data[1]) . "\""
                        . ",\"" . str_replace(" ", "", $data[2]) . "\""
                        . "," . trim($data[3])
                        . "," . floatval(trim($data[3])) * (1 + $margin)  . "),";

                    $charge = $charge + floatval(trim($data[3])) * (1 + $margin);
                }
            }
            $query = substr($query, 0, -1); //remove the last ,
            $link = getConnection();
            executeUpdateQuery($link, $query);
            closeConnection($link);

            $remain_balance = floatval($client->getBalance()) - $charge;
            $client->updateBalance($remain_balance);
        }
    }

    public function getAdminCallLogTableDataSource($start = "", $end = "", $client_id = 0)
    {
        $call_log_list = $this->loadCallLogList($start, $end, $client_id);
        $dataSource = array();
        if (sizeof($call_log_list) > 0) {
            foreach ($call_log_list as $callLog) {
                array_push($dataSource, array(
                    "id" => $callLog->getLogId(),
                    "client_id" => $callLog->getClientId(),
                    "client_name" => $callLog->getClientName(),
                    "call_number" => $callLog->getCallNumber(),
                    "timestamp" => $callLog->getStartTimestamp(),
                    "duration" => $callLog->getDuration(),
                    "base_rate" => $callLog->getBaseRate(),
                    "charge" => $callLog->getCharge(),
                ));
            }
        }
        return $dataSource;
    }

    public function getClientCallLogTableDataSource($start = "", $end = "", $client_id = 0)
    {
        $call_log_list = $this->loadCallLogList($start, $end, $client_id);
        $dataSource = array();
        if (sizeof($call_log_list) > 0) {
            foreach ($call_log_list as $callLog) {
                array_push($dataSource, array(
                    "id" => $callLog->getLogId(),
                    "call_number" => $callLog->getCallNumber(),
                    "timestamp" => $callLog->getStartTimestamp(),
                    "duration" => $callLog->getDuration(),
                    "charge" => $callLog->getCharge()
                ));
            }
        }
        return $dataSource;
    }

    public function getClientCallLogPrintingContent($start = "", $end = "", $client_id = 0){
        $client = new Client();
        $client->loadByID($client_id);
        $call_log_list = $this->loadCallLogList($start, $end, $client_id);

        $css = "<style>";
        $header= "<div class='body'><div id='header'><img src='http://www.billing.rosetelecom.co.uk/images/roselogo.png'><table><tr><td width=150><b>Client Name:</b></td><td width=250>".$client->getFullName()."</td><td width=150><b>Email:</b></td><td width=250>".$client->getEmail()."</td></tr><tr><td><b>Start Date:</b></td><td>".$start."</td><td><b>End Date:</b></td><td>".$end."</td></tr></table></div>";
        $body= "<div id='log_table'><table><tr><td width=200><b>Calling At</b></td><td width=250><b>Start At</b></td><td width=200><b>Duration</b></td><td width=150><b>Charge</b></td></tr>";

        if (sizeof($call_log_list) > 0) {
            foreach ($call_log_list as $callLog) {
                $body = $body. "<tr><td>".$callLog->getCallNumber()
                    ."</td><td>".$callLog->getStartTimestamp()
                    ."</td><td>".$callLog->getDuration()
                    ."</td><td>".$callLog->getCharge()."</td></tr>";
            }
        }


        $body = $body."</table></div></div>";
        $content = $header. $body;
        return $content;
    }
}

?>