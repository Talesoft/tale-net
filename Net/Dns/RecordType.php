<?php

namespace Tale\Net\Dns;

class RecordType
{

    const A = \DNS_A;
    const MX = \DNS_MX;
    const NS = \DNS_NS;
    const SOA = \DNS_SOA;
    const PTR = \DNS_PTR;
    const CNAME = \DNS_CNAME;
    const AAAA = \DNS_AAAA;
    const A6 = \DNS_A6;
    const SRV = \DNS_SRV;
    const NAPTR = \DNS_NAPTR;
    const HINFO = \DNS_HINFO;
    const TXT = \DNS_TXT;
    const ALL = \DNS_ALL;
    const ANY = \DNS_ANY;

    private function __construct() {}

    public static function getName($type)
    {

        switch ($type) {
            case self::A: return 'A';
            case self::MX: return 'MX';
            case self::NS: return 'NS';
            case self::SOA: return 'SOA';
            case self::PTR: return 'PTR';
            case self::CNAME: return 'CNAME';
            case self::AAAA: return 'AAAA';
            case self::A6: return 'A6';
            case self::SRV: return 'SRV';
            case self::NAPTR: return 'NAPTR';
            case self::HINFO: return 'HINFO';
            case self::TXT: return 'TXT';
            case self::ALL: return 'ALL';
            case self::ANY: return 'ANY';
        }

        throw new \InvalidArgumentException(
            "Record type $type has no type constant associated"
        );
    }
}