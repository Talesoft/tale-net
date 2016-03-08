<?php

namespace Tale\Net\Unix;

use Tale\Net\EndPoint,
    Tale\Net\AddressFamily;

class UnixEndPoint extends EndPoint
{

    private $path;

    public function __construct($path)
    {
        parent::__construct(AddressFamily::UNIX);

        $this->path = $path;
    }

    public function getPath()
    {

        return $this->path;
    }
}