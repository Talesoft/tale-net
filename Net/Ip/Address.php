<?php

namespace Tale\Net\Ip;

use Tale\Net\AddressFamily,
    Tale\Net\Dns;

class Address
{

    private $_bytes;
    private $_family;

    public function __construct(array $bytes)
    {

        $this->_bytes = $bytes;

        switch (count($this->_bytes)) {
            case 4:
                $this->_family = AddressFamily::INET;
                break;
            case 16:
                $this->_family = AddressFamily::INET6;
                break;
            default:

                throw new \InvalidArgumentException(
                    "Failed to construct IP address: Passed bytes dont count ".
                    "for any known AddressFamily. Try 4 (IPv4) or 16 (IPv6) bytes"
                );
        }
    }

    public function getBytes()
    {

        return $this->_bytes;
    }

    public function getHexBytes()
    {

        return array_map(function ($byte) {

            return str_pad(dechex($byte), 2, '0', \STR_PAD_LEFT);
        }, $this->_bytes);
    }

    public function getFamily()
    {

        return $this->_family;
    }

    public function isV4()
    {

        return $this->_family === AddressFamily::INET;
    }

    public function isV6()
    {

        return $this->_family === AddressFamily::INET6;
    }

    public function getReverseHostName()
    {

        $str = null;
        if ($this->isV4())
            return implode('.', array_reverse($this->getBytes())).'.in-addr.arpa';

        if ($this->isV6()) {

            $hexParts = $this->getHexBytes();
            $bytes = [];
            foreach ($hexParts as $part) {

                $bytes[] = $part[0];
                $bytes[] = $part[1];
            }

            return implode('.', array_reverse($bytes)).'.ip6.arpa';
        }

        throw new \InvalidArgumentException(
            "Failed to build reverse host name: Passed ip address needs to be either V4 or V6"
        );
    }

    public function lookUp()
    {

        return Dns::lookUpReverse($this);
    }

    public function lookUpArray()
    {

        return iterator_to_array($this->lookUp());
    }

    public function lookUpFirst()
    {

        return Dns::lookUpReverseFirst($this);
    }

    public function lookUpHostName()
    {

        $first = $this->lookUpFirst();

        if (!$first)
            return null;

        return $first->getTargetHostName();
    }

    public function __toString()
    {

        return inet_ntop(implode(array_map('chr', $this->_bytes)));
    }

    public static function isAddress($string, $flags = null)
    {

        $flags = $flags ?: 0;
        return filter_var($string, FILTER_VALIDATE_IP | $flags);
    }

    public static function isAddressV4($string)
    {

        return self::isAddress($string, FILTER_FLAG_IPV4);
    }

    public static function isAddressV6($string)
    {

        return self::isAddress($string, FILTER_FLAG_IPV6);
    }

    public static function fromString($string, $v6 = false)
    {

        if (self::isAddress($string)) {

            $n = @inet_pton($string);

            if ($n === false)
                throw new \RuntimeException(
                    "Failed to convert string to IPAddress: Conversion failed (".error_get_last()['message'].")"
                );

            return new static(array_map('ord', str_split($n)));
        }

        $record = $v6 ? Dns::lookUpAaaaRecord($string) : Dns::lookUpARecord($string);

        if (!$record)
            throw new \RuntimeException(
                "Failed to look up IP address for host $string. No matching records found"
            );

        return $record->getAddress();
    }
}