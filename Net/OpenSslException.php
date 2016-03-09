<?php

namespace Tale\Net;

use Exception;

class OpenSslException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {

        while (($error = openssl_error_string()) !== false)
            $message .= "\n    $error";

        parent::__construct($message, $code, $previous);
    }
}