<?php
namespace includes\classes;

use includes\classes\Rate;
use includes\classes\Client;

class RateManager
{

    private function loadRateList()
    {
        $rate_list = array();
        $link = getConnection();
        $query = " select    destination,
                              rate
                    from    rate ";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $rate = new Rate();
            $rate->setDestination($newArray['destination']);
            $rate->setRate($newArray['rate']);
            array_push($rate_list, $rate);
        }
        return $rate_list;
    }

    private function deleteAllRate()
    {
        $link = getConnection();
        $query = " DELETE FROM rate";
        executeUpdateQuery($link, $query);
        closeConnection($link);
    }

    public function reloadNewRate($array_from_csv = array())
    {
        if (!is_null($array_from_csv) && sizeof($array_from_csv) > 0) {
            //step 1, delete the table data
            $this->deleteAllRate();

            //step 2, build up insert query
            $query = "INSERT INTO rate (destination, rate) VALUES ";
            foreach ($array_from_csv as $data) {
                if ($data[0] != "") {
                    $query = $query . "(\"" . $data[0] . "\"," . $data[1] . "),";
                }
            }
            $query = substr($query, 0, -1); //remove the last ,
            $link = getConnection();
            executeUpdateQuery($link, $query);
            closeConnection($link);
        }
    }

    public function getAdminRateTableDataSource()
    {
        $rate_list = $this->loadRateList();
        $dataSource = array();
        if (sizeof($rate_list) > 0) {
            foreach ($rate_list as $rate) {
                array_push($dataSource, array(
                    "destination" => $rate->getDestination(),
                    "rate" => $rate->getRate(),
                ));
            }
        }
        return $dataSource;
    }

    public function getClientRateTableDataSource($client_id)
    {
        $client = New Client();
        $client->loadByID($client_id);
        $margin = $client->getMargin();
        $rate_list = $this->loadRateList();
        $dataSource = array();
        if (sizeof($rate_list) > 0) {
            foreach ($rate_list as $rate) {
                array_push($dataSource, array(
                    "destination" => $rate->getDestination(),
                    "rate" => number_format(floatval($rate->getRate()) * (1 + $margin),2),
                ));
            }
        }
        return $dataSource;
    }
}

?>