<?php

namespace includes\classes;

class Rate
{
    private $destination;
    private $rate;

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getRate()
    {
        return $this->rate;
    }



}
?>