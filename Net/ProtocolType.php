<?php

namespace Tale\Net;

use Tale\Enum;

//http://php.net/manual/de/function.getprotobyname.php
class ProtocolType
{

    const IP = 'ip';
    const ICMP = 'icmp';
    const GGP = 'ggp';
    const TCP = 'tcp';
    const EGP = 'egp';
    const PUP = 'pup';
    const UDP = 'udp';
    const HMP = 'hmp';
    const XNX_IDP = 'xns-idp';
    const RDP = 'rdp';
    const RVD = 'rvd';

    private function __construct() {}

    public static function getNumber($type)
    {

        return getprotobyname($type);
    }
}