<?php
namespace  includes\classes;

use includes\classes\Client;

class ClientManager {

    private function loadClientList($is_active = "Y"){
    $client_list = array();
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

    public function getClientMarginMap(){
        $map = array();
        $link = getConnection();
        $query = " select   client_id,
                             margin
                    from    client";

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $map[trim($newArray['client_id'])] = $newArray['margin'];
        }
        return $map;
    }

    public function updateClientsBalance($client_id_list = array()){
        if (sizeof($client_id_list) > 0) {
            foreach ($client_id_list as $client_id) {
                $client = new Client();
                $client->setClientId($client_id);
                $client->updateBalance();
            }
        }
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

    public function getActiveClientlistDataSource()
    {
        $clientList = $this->loadClientList("Y");
        $data = array();
        if (sizeof($clientList) > 0) {
            foreach ($clientList as $client) {
                $data[$client->getEmail() . " - ". $client->getFirstname() ." ". $client->getLastname()] = $client->getClientId();
            }
        }
        $dataSource = array(
            "data" => $data
        );
        return $dataSource;
    }

    //put your code here
    public function login($email, $password)
    {
        $link = getConnection();
        $loginResult = false;
        $password = md5($password);

        $query = " select client_id,
                        email,
                        active
                from    client
                where   active =   'Y'
                and     email =       '" . $email . "'
                and     password =   '" . $password . "'";


        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        $num_rows = mysql_num_rows($result); // Find no. of rows retrieved from DB

        if ($num_rows == 1) {
            $loginResult = true; // login successful
        } else {
            $loginResult = false; // login failure
        }
        return $loginResult;
    }
}

?>