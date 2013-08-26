<?php
namespace  includes\classes;

class Payment
{
    private $payment_id;
    private $client_id;
    private $client_name;
    private $timestamp;
    private $amount;
    private $actual_cost;
    private $payment_method;
    private $remark;

    public function setActualCost($actual_cost)
    {
        $this->actual_cost = $actual_cost;
    }

    public function getActualCost()
    {
        return $this->actual_cost;
    }

    public function setClientName($client_name)
    {
        $this->client_name = $client_name;
    }

    public function getClientName()
    {
        return $this->client_name;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
    }

    public function getPaymentId()
    {
        return $this->payment_id;
    }

    public function setPaymentMethod($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function getPaymentMethod()
    {
        return $this->payment_method;
    }

    public function setRemark($remark)
    {
        $this->remark = $remark;
    }

    public function getRemark()
    {
        return $this->remark;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function loadByID($id)
    {
        $link = getConnection();
        $query = " SELECT     payment_id,
                              client_id,
                              CONCAT(client.firstname , ' ', client.lastname) AS client_name,
                              timestamp,
                              amount,
                              actual_cost,
                              payment_method,
                              remark
                     FROM  payment, client
                     WHERE client.client_id = payment.client_id
                     AND payment_id =  " . $id;

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $this->setPaymentId($newArray['payment_id']);
            $this->setClientId($newArray['client_id']);
            $this->setClientName($newArray['client_name']);
            $this->setTimestamp($newArray['timestamp']);
            $this->setAmount($newArray['amount']);
            $this->setActualCost($newArray['actual_cost']);
            $this->setPaymentMethod($newArray['payment_method']);
            $this->setRemark($newArray['remark']);
        }
    }

    public function insert()
    {
        $link = getConnection();

        $query = "INSERT INTO payment
                            (client_id,
                             timestamp,
                             amount,
                             actual_cost,
                             payment_method,
                             remark)
                        VALUES (". $this->getClientId() . ",
                                NOW(),
                                " . $this->getAmount() . ",
                                " . $this->getActualCost() . ",
                                '" . $this->getPaymentMethod() . "',
                                '" . $this->getRemark() . "')";

        executeUpdateQuery($link, $query);

        $payment_id = mysql_insert_id($link);
        $this->setPaymentId($payment_id);
        closeConnection($link);
    }

}


?>