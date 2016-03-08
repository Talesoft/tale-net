<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\Record;
use Tale\Net\Dns\RecordType;
use Tale\Net\Ip\Address;

class A extends Record
{

    private $address;

    public function __construct($hostName, Address $address, $ttl, $type = null)
    {
        parent::__construct($hostName, $type ? $type : RecordType::A, $ttl);

        $this->address = $address;
    }

    public function getAddress()
    {

        return $this->address;
    }

    public function getAddressString()
    {

        return $this->address->getString();
    }

    public function __toString()
    {

        return parent::__toString().' '.$this->getAddressString();
    }
}