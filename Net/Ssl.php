<?php

namespace Tale\Net;

class Ssl
{

    private function __construct() {}

    public static function generatePrivateKey()
    {

        return openssl_pkey_new()
    }
}