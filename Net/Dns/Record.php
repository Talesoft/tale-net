<?php

namespace Tale\Net\Dns;

//TODO: Implement Record\Naptr

class Record
{

    private $hostName;
    private $type;
    private $ttl;

    public function __construct($hostName, $type, $ttl)
    {

        $this->hostName = $hostName;
        $this->type = $type;
        $this->ttl = $ttl;
    }

    public function getHostName()
    {

        return $this->hostName;
    }

    public function getType()
    {

        return $this->type;
    }

    public function getTtl()
    {

        return $this->ttl;
    }

    public function __toString()
    {

        return get_class($this).' '.$this->hostName;
    }
}