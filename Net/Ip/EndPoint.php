<?php

namespace Tale\Net\Ip;

use Tale\Net\EndPoint as NetEndPoint;

class EndPoint extends NetEndPoint
{

    private $address;
    private $port;

    public function __construct(Address $address, $port)
    {
        parent::__construct($address->getFamily());

        $this->address = $address;
        $this->port = $port;
    }

    public function getAddress()
    {

        return $this->address;
    }

    public function getPort()
    {

        return $this->port;
    }

    public function __toString()
    {

        $address = (string)$this->address;
        if ($this->address->isV6())
            $address = "[$address]";

        return "$address:{$this->port}";
    }

    public static function fromString($string, $v6 = false)
    {

        $parts = explode(':', strrev($string), 2);

        if (count($parts) !== 2)
            throw new \InvalidArgumentException(
                "Failed to create endpoint from string: No IP address or port passed"
            );

        return new static(Address::fromString(trim(strrev($parts[1]), '[]'), $v6), intval(strrev($parts[0])));
    }
}