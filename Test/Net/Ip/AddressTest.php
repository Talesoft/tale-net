<?php

namespace Tale\Test\Net\Ip;

use Tale\Net\Ip\Address;
use Tale\Net\Ip\EndPoint;

class AddressTest extends \PHPUnit_Framework_TestCase
{

    public function testReverseLookUp()
    {

        $addr = Address::fromString('80.237.132.135');
        $this->assertEquals('135.132.237.80.in-addr.arpa', $addr->getReverseHostName());
        $this->assertEquals('wp128.webpack.hosteurope.de', $addr->lookUpHostName());
    }

    public function testReverseLookUpV6()
    {

        $addr = Address::fromString('2a01:488:42:1000:50ed:8487:35:d5cd');
        $this->assertEquals('d.c.5.d.5.3.0.0.7.8.4.8.d.e.0.5.0.0.0.1.2.4.0.0.8.8.4.0.1.0.a.2.ip6.arpa', $addr->getReverseHostName());
        $this->assertEquals('talesoft.io', $addr->lookUpHostName());
    }
}