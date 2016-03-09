<?php

use Tale\Net\OpenSsl\SigningRequest;

include 'vendor/autoload.php';

$csr = new SigningRequest([
    'countryName' => 'UK',
    'stateOrProvinceName' => 'Somerset',
    'localityName' => 'Glastonbury',
    'organizationName' => 'The Brain Room Limited',
    'organizationalUnitName' => 'PHP Documentation Team',
    'commonName' => 'Wez Furlong',
    'emailAddress' => 'wez@example.com'
], null, ['configFile' => 'C:\Xampp\php\extras\openssl\openssl.cnf']);

var_dump($csr->getRequestText());