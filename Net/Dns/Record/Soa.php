<?php

namespace Tale\Net\Dns\Record;

use Tale\Net\Dns\Record;
use Tale\Net\Dns\RecordType;

class Soa extends Record
{

    private $sourceHostName;
    private $mailAddress;
    private $serial;
    private $refreshInterval;
    private $retryDelay;
    private $expireTime;
    private $minTtl;

    public function __construct($hostName, $sourceHostName, $mailAddress, $serial, $refreshInterval, $retryDelay, $expireTime, $minTtl, $ttl)
    {
        parent::__construct($hostName, RecordType::SOA, $ttl);

        $this->sourceHostName = $sourceHostName;
        $this->mailAddress = $mailAddress;
        $this->serial = $serial;
        $this->refreshInterval = $refreshInterval;
        $this->retryDelay = $retryDelay;
        $this->expireTime = $expireTime;
        $this->minTtl = $minTtl;
    }

    public function getSourceHostName()
    {

        return $this->sourceHostName;
    }

    public function getMailAddress()
    {

        return $this->mailAddress;
    }

    public function getSerial()
    {

        return $this->serial;
    }

    public function getRefreshInterval()
    {

        return $this->refreshInterval;
    }

    public function getRetryDelay()
    {

        return $this->retryDelay;
    }

    public function getExpireTime()
    {

        return $this->expireTime;
    }

    public function getMinTtl()
    {

        return $this->minTtl;
    }

    public function __toString()
    {

        $str = implode(' ', [
            $this->sourceHostName,
            $this->mailAddress,
            $this->serial,
            $this->refreshInterval,
            $this->retryDelay,
            $this->expireTime,
            $this->minTtl
        ]);

        return parent::__toString()." $str";
    }
}