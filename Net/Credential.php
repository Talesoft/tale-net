<?php

namespace Tale\Net;

class Credential
{

    private $userName;
    private $password;

    public function __construct($userName = null, $password = null)
    {

        $this->userName = $userName;
        $this->password = $password;
    }

    public function hasUserName()
    {

        return !is_null($this->userName);
    }

    public function getUserName()
    {

        return $this->userName;
    }

    public function hasPassword()
    {

        return !$this->password !== null;
    }

    public function getPassword()
    {

        return $this->password;
    }
}