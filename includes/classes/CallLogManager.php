<?php
namespace includes\classes;

use includes\classes\CallLog;
use includes\classes\Client;
use includes\classes\ClientManager;

class CallLogManager
{

    private function loadCallLogList($start = "", $end = "", $client_id = "")
    {
        $call_log_list = array();
        $link = getConnection();
        $query = "  SELECT    log_id,
                              call_log.client_id,
                              CONCAT(client.firstname , ' ', client.lastname) AS client_name,
                              call_number,
                              destination,
                              timestamp,
                              duration,
                              base_rate,
                              charge
                     FROM  call_log, client
                     WHERE client.client_id = call_log.client_id
                     AND   timestamp >= '" . $start . "'
                     AND   timestamp <= '" . $end . "' ";
        if ($client_id != "") {
            $query = $query . "AND call_log.client_id = '" . $client_id."' ";
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
            $callLog->setDestination($newArray['destination']);
            $callLog->setStartTimestamp($newArray['timestamp']);
            $callLog->setDuration($newArray['duration']);
            $callLog->setBaseRate($newArray['base_rate']);
            $callLog->setCharge($newArray['charge']);
            array_push($call_log_list, $callLog);
        }
        return $call_log_list;
    }

    public function appendNewLog($array_from_csv = array())
    {
        $updated_client_id_list = array(); // hold a list of client's id who has been proceed with new call log
        $clientMarginMap = array(); // $clientMarginMap["client id"] = 0.20
        $clientManager = new ClientManager();
        $clientMarginMap = $clientManager->getClientMarginMap();

        if (!is_null($array_from_csv) && sizeof($array_from_csv) > 0) {
            //build up insert query
            $query = "INSERT INTO call_log (client_id, timestamp, call_number, destination, duration, base_rate, charge) VALUES ";
            foreach ($array_from_csv as $data) {
                if (trim($data[0]) != "") {
                    $margin = floatval($clientMarginMap[trim($data[0])]);

                    $query = $query . "("
                        . "\"" . trim($data[0]) . "\"" //client_id
                        . ",\"" . trim($data[1]) . "\"" //timestamp
                        . ",\"" . trim($data[2]) . "\"" //call_number
                        . ",\"" . trim($data[3]) . "\"" //destination
                        . ",\"" . str_replace(" ", "", $data[4]) . "\"" //duration
                        . "," . trim($data[5]) //base_rate
                        . "," . floatval(trim($data[5])) * (1 + $margin) . "),"; //charge

                    // add this client list
                    array_push($updated_client_id_list, trim($data[0]));

                }
            }
            $query = substr($query, 0, -1); //remove the last ,
            $link = getConnection();
            executeUpdateQuery($link, $query);
            closeConnection($link);

            // remove all the duplicated client id
            $updated_client_id_list = array_unique($updated_client_id_list);

            // finally, update client balance
            $clientManager->updateClientsBalance($updated_client_id_list);
        }


    }

    public function getAdminCallLogTableDataSource($start = "", $end = "", $client_id = "")
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

    public function getClientCallLogTableDataSource($start = "", $end = "", $client_id = "")
    {
        $call_log_list = $this->loadCallLogList($start, $end, $client_id);
        $dataSource = array();
        if (sizeof($call_log_list) > 0) {
            foreach ($call_log_list as $callLog) {
                array_push($dataSource, array(
                    "id" => $callLog->getLogId(),
                    "call_number" => $callLog->getCallNumber(),
                    "destination" => $callLog->getDestination(),
                    "timestamp" => $callLog->getStartTimestamp(),
                    "duration" => $callLog->getDuration(),
                    "charge" => $callLog->getCharge()
                ));
            }
        }
        return $dataSource;
    }

    public function getClientCallLogPrintingContent($start = "", $end = "", $client_id = "")
    {
        $client = new Client();
        $client->loadByID($client_id);
        $call_log_list = $this->loadCallLogList($start, $end, $client_id);

        $duration = "";
        $charge = 0.0;
        $link = getConnection();
        $query = "  SELECT    SUM(TIME_TO_SEC(duration)) AS duration ,
                              SUM(charge) as charge
                     FROM  call_log
                     WHERE client_id = '".$client_id."'
                     AND   timestamp >= '" . $start . "'
                     AND   timestamp <= '" . $end . "' ";
        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);
        $newArray = mysql_fetch_array($result);
        $duration = $this->foo($newArray['duration']);
        $charge = number_format($newArray['charge'], 2). " ".$client->getCurrency() ;
        $size = sizeof($call_log_list);

        $css = "<style>";
        $header = "<div class='body'><div id='header'><img src='http://www.billing.rosetelecom.co.uk/images/roselogo.png'><table><tr><td width=150><b>Client Name:</b></td><td width=250>" . $client->getFullName() . "</td><td width=150><b>Email:</b></td><td width=250>" . $client->getEmail() . "</td></tr><tr><td><b>Start Date:</b></td><td>" . $start . "</td><td><b>Total Duration:</b></td><td>" . $duration . "</td></tr><tr><td><b>End Date:</b></td><td>" . $end . "</td><td><b>Total Charge:</b></td><td>" . $charge . "</td></tr><tr><td></td><td></td><td><b>Number of Calls:</b></td><td>" . $size . "</td></tr></table></div>";
        $body = "<div id='log_table'><table><tr><td width=200><b>Calling Number</b></td><td width=200><b>Destination</b></td><td width=180><b>Start At</b></td><td width=100><b>Duration</b></td><td width=100><b>Charge</b></td></tr>";

        if (sizeof($call_log_list) > 0) {
            foreach ($call_log_list as $callLog) {
                $body = $body . "<tr><td>" . $callLog->getCallNumber()
                    . "</td><td>" . $callLog->getDestination()
                    . "</td><td>" . $callLog->getStartTimestamp()
                    . "</td><td>" . $callLog->getDuration()
                    . "</td><td>" . $callLog->getCharge() . "</td></tr>";
            }
        }


        $body = $body . "</table></div></div>";
        $content = $header . $body;
        return $content;
    }

    public function foo($seconds) {
        $t = round($seconds);
        return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
    }

}

?>