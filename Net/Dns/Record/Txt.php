<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\Record;
use Tale\Net\Dns\RecordType;

class Txt extends Record
{

    private $text;

    public function __construct($hostName, $text, $ttl)
    {
        parent::__construct($hostName, RecordType::TXT, $ttl);

        $this->text = $text;
    }

    public function getText()
    {

        return $this->text;
    }

    public function __toString()
    {

        return parent::__toString().' '.$this->text;
    }
}