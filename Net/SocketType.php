<?php

namespace Tale\Net;

class SocketType
{

    const STREAM = \SOCK_STREAM;
    const DGRAM = \SOCK_DGRAM;
    const SEQPACKET = \SOCK_SEQPACKET;
    const RAW = \SOCK_RAW;
    const RDM = \SOCK_RDM;

    private function __construct() {}
}