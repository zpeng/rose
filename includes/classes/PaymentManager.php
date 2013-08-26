<?php
namespace  includes\classes;

use includes\classes\Payment;

class PaymentManager {

    private function loadPaymentList($start = "", $end = "", $client_id = 0 ){
        $payment_list = array();
        $link = getConnection();
        $query = "  SELECT    payment_id,
                              payment.client_id,
                              CONCAT(client.firstname , ' ', client.lastname) AS client_name,
                              timestamp,
                              amount,
                              actual_cost,
                              payment_method,
                              remark
                     FROM  payment, client
                     WHERE client.client_id = payment.client_id
                     AND   timestamp >= '".$start."'
                     AND   timestamp <= '".$end."' ";
        if ($client_id != 0) {
            $query = $query. "AND payment.client_id = ".$client_id;
        }

        $result = executeNonUpdateQuery($link, $query);
        closeConnection($link);

        while ($newArray = mysql_fetch_array($result)) {
            $payment = new Payment();
            $payment->setPaymentId($newArray['payment_id']);
            $payment->setClientId($newArray['client_id']);
            $payment->setClientName($newArray['client_name']);
            $payment->setTimestamp($newArray['timestamp']);
            $payment->setAmount($newArray['amount']);
            $payment->setActualCost($newArray['actual_cost']);
            $payment->setPaymentMethod($newArray['payment_method']);
            $payment->setRemark($newArray['remark']);
            array_push($payment_list, $payment);
        }
        return $payment_list;
    }

    public function getAdminPaymentTableDataSource($start = "", $end = "", $client_id = 0)
    {
        $payment_list = $this->loadPaymentList($start, $end, $client_id);
        $dataSource = array();
        if (sizeof($payment_list) > 0) {
            foreach ($payment_list as $payment) {
                array_push($dataSource, array(
                    "id" => $payment->getPaymentId(),
                    "client_id" => $payment->getClientId(),
                    "client_name" => $payment->getClientName(),
                    "timestamp" => $payment->getTimestamp() ,
                    "amount" => $payment->getAmount(),
                    "actual_cost" => $payment->getActualCost(),
                    "payment_method" => $payment->getPaymentMethod(),
                    "remark" => $payment->getRemark(),
                ));
            }
        }
        return $dataSource;
    }

    public function getClientPaymentTableDataSource($start = "", $end = "", $client_id = 0)
    {
        $payment_list = $this->loadPaymentList($start, $end, $client_id);
        $dataSource = array();
        if (sizeof($payment_list) > 0) {
            foreach ($payment_list as $payment) {
                array_push($dataSource, array(
                    "id" => $payment->getPaymentId(),
                    "timestamp" => $payment->getTimestamp() ,
                    "amount" => $payment->getAmount(),
                    "payment_method" => $payment->getPaymentMethod()
                ));
            }
        }
        return $dataSource;
    }
}

?>