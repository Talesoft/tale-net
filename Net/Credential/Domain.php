<?php

namespace Tale\Net\Credential;

use Tale\Net\Credential;

class Domain extends Credential
{

    private $domain;

    public function __construct($userName = null, $password = null, $domain = null)
    {
        parent::__construct($userName, $password);

        $this->domain = $domain;
    }

    public function hasDomain()
    {

        return $this->domain !== null;
    }

    public function getDomain()
    {

        return $this->domain;
    }

    public function setDomain($domain)
    {

        $this->domain = $domain;

        return $this;
    }
}