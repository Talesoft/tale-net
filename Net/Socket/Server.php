<?php

namespace Tale\Net\Socket;

use Psr\Http\Message\UriInterface;
use Tale\Net\SocketBase;

class Server extends SocketBase
{

    public function __construct($uri, $flags = null)
    {

        if ($uri instanceof UriInterface)
            $context = (string)$uri;

    }
}