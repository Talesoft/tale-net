<?php

namespace Tale\Net;

class EndPoint
{

    private $addressFamily;

    public function __construct($addressFamily)
    {

        $this->addressFamily = $addressFamily;
    }

    public function getAddressFamily()
    {

        return $this->addressFamily;
    }
}