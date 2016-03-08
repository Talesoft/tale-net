<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\RecordType;

class Srv extends Mx
{

    private $port;
    private $weight;

    public function __construct($hostName, $targetHostName, $port, $priority, $weight, $ttl, $type = null)
    {
        parent::__construct($hostName, $targetHostName, $priority, $ttl, RecordType::SRV);

        $this->port = $port;
        $this->weight = $weight;
    }

    public function getPort()
    {

        return $this->port;
    }

    public function getWeight()
    {

        return $this->weight;
    }

    public function __toString()
    {

        return parent::__toString().' '.$this->port.' '.$this->weight;
    }
}