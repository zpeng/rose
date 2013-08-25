<?php
namespace  includes\classes;

use includes\classes\Client;

class ClientManager {

    private function loadClientList($is_active = "Y"){
        $client_list = [];
        $link = getConnection();
        $query = " select    client_id,
                              email,
                              firstname,
                              lastname,
                              currency,
                              balance,
                              margin,
                              active
                    from    client
                    where   active =   '".$is_active."'";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $client = new Client();
            $client->setClientId($newArray['client_id']);
            $client->setEmail($newArray['email']);
            $client->setFirstname($newArray['firstname']);
            $client->setLastname($newArray['lastname']);
            $client->setCurrency($newArray['currency']);
            $client->setBalance($newArray['balance']);
            $client->setMargin($newArray['margin']);
            $client->setActive($newArray['active']);

            array_push($client_list, $client);
        }
        return $client_list;
    }

    public function getClientTableDataSource($is_active = "Y")
    {
        $clientList = $this->loadClientList($is_active);
        $dataSource = array();
        if (sizeof($clientList) > 0) {
            foreach ($clientList as $client) {
                array_push($dataSource, array(
                    "id" => $client->getClientId(),
                    "email" => $client->getEmail(),
                    "name" => $client->getFirstname() ." ". $client->getLastname() ,
                    "currency" => $client->getCurrency(),
                    "balance" => $client->getBalance(),
                    "margin" => $client->getMargin(),
                    "action" => ""
                ));
            }
        }
        return $dataSource;
    }
}

?>