<?php

namespace Tale\Net;

class AddressFamily
{

    const INET = \AF_INET;
    const INET6 = \AF_INET6;
    const UNIX = \AF_UNIX;

    private function __construct() {}
}