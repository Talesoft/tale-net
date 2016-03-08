<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\RecordType;
use Tale\Net\Ip\Address;

class A6 extends A
{

    private $chainedHostName;
    private $maskLength;

    public function __construct($hostName, $chainedHostName, Address $address, $maskLength, $ttl)
    {
        parent::__construct($hostName, $address, $ttl, RecordType::A6);

        $this->chainedHostName = $chainedHostName;
        $this->maskLength = $maskLength;
    }

    public function getChainedHostName()
    {

        return $this->chainedHostName;
    }

    public function getMaskLength()
    {

        return $this->maskLength;
    }

    public function __toString()
    {

        return parent::__toString().' '.$this->getChainedHostName().' '.$this->getMaskLength();
    }
}