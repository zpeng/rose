<?php
namespace includes\classes;


class CallLog {
    private $log_id;
    private $client_id;
    private $client_name;
    private $call_number;
    private $start_timestamp;
    private $duration;
    private $base_rate;
    private $charge;

    public function setBaseRate($base_rate)
    {
        $this->base_rate = $base_rate;
    }

    public function getBaseRate()
    {
        return $this->base_rate;
    }

    public function setCallNumber($call_number)
    {
        $this->call_number = $call_number;
    }

    public function getCallNumber()
    {
        return $this->call_number;
    }

    public function setCharge($charge)
    {
        $this->charge = $charge;
    }

    public function getCharge()
    {
        return $this->charge;
    }

    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientId()
    {
        return $this->client_id;
    }

    public function setClientName($client_name)
    {
        $this->client_name = $client_name;
    }

    public function getClientName()
    {
        return $this->client_name;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setLogId($log_id)
    {
        $this->log_id = $log_id;
    }

    public function getLogId()
    {
        return $this->log_id;
    }

    public function setStartTimestamp($start_timestamp)
    {
        $this->start_timestamp = $start_timestamp;
    }

    public function getStartTimestamp()
    {
        return $this->start_timestamp;
    }




}