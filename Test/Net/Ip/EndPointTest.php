<?php

namespace Tale\Test\Net\Ip;

use Tale\Net\Ip\EndPoint;

class EndPointTest extends \PHPUnit_Framework_TestCase
{

    public function testFromString()
    {

        $ep = EndPoint::fromString('talesoft.io:8443');
        $this->assertEquals('80.237.132.135', (string)$ep->getAddress());
        $this->assertEquals(8443, $ep->getPort());
    }

    public function testFromStringV6()
    {

        $ep = EndPoint::fromString('talesoft.io:8443', true);
        $this->assertEquals('2a01:488:42:1000:50ed:8487:35:d5cd', (string)$ep->getAddress());
        $this->assertEquals(8443, $ep->getPort());

        $ep = EndPoint::fromString('[::1]:8443', true);
        $this->assertEquals('::1', (string)$ep->getAddress());
        $this->assertEquals(8443, $ep->getPort());
        $this->assertEquals('[::1]:8443', (string)$ep);
    }
}