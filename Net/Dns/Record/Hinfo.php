<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\Record;
use Tale\Net\Dns\RecordType;

class Hinfo extends Record
{

    private $cpu;
    private $os;

    public function __construct($hostName, $cpu, $os, $ttl)
    {
        parent::__construct($hostName, RecordType::HINFO, $ttl);

        $this->cpu = $cpu;
        $this->os = $os;
    }

    public function getCpu()
    {

        return $this->cpu;
    }

    public function getOs()
    {

        return $this->os;
    }

    public function __toString()
    {

        return parent::__toString().' '.$this->cpu.' '.$this->os;
    }
}