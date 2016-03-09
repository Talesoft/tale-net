<?php

namespace Tale\Net\OpenSsl\SigningRequest;

class Info
{

    protected $fields = [
        'countryName',
        'stateOrProvinceName',
        'localityName',
        'organizationName',
        'organizationalUnitName',
        'commonName',
        'emailAddress'
    ];

    private $items;

    public function __construct(array $infos = null)
    {

        $this->items = $infos ?: [];
    }

    /**
     * @return array
     */
    public function getItems()
    {

        return $this->items;
    }

    /**
     * @param array $items
     *
     * @return Info
     */
    public function setItems($items)
    {

        $this->items = $items;

        return $this;
    }

    public function has($key)
    {

        return isset($this->items[$key]);
    }

    public function get($key)
    {

        return $this->items[$key];
    }

    public function set($key, $value)
    {

        $this->items[$key] = $value;

        return $this;
    }

    public function validate()
    {

        foreach ($this->fields as $field)
            if (!$this->has($field))
                throw new \RuntimeException(
                    "Failed to validate CSR: $field is not defined"
                );
    }

    public function __call($method, array $args)
    {

        if (strlen($method) <= 3)
            throw new \BadMethodCallException(
                "Method $method does not exist on ".get_class($this)
            );

        $action = substr($method, 0, 3);
        $subject = lcfirst(substr($method, 3));

        if (!in_array($subject, $this->fields, true))
            throw new \BadMethodCallException(
                "Failed to call $method: $subject is not a valid field on ".
                get_class($this)
            );

        if (!in_array($action, ['has', 'get', 'set']))
            throw new \BadMethodCallException(
                "Failed to call $method: $action is not a valid action on ".
                get_class($this)
            );

        if ($action === 'set' && count($args) !== 1)
            throw new \BadMethodCallException(
                "Failed to call $subject-setter: No or too many arguments given"
            );

        if (in_array($action, ['get', 'has'], true) && count($args) !== 0)
            throw new \BadMethodCallException(
                "Failed to call $method: $action expects no arguments"
            );

        if ($action === 'set')
            return $this->$action($subject, $args[0]);

        return $this->$action($subject);
    }
}