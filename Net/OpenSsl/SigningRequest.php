<?php

namespace Tale\Net\OpenSsl;

use Tale\ConfigurableTrait;
use Tale\Net\OpenSslException;

class SigningRequest
{
    use ConfigurableTrait;

    protected $fields = [
        'countryName',
        'stateOrProvinceName',
        'localityName',
        'organizationName',
        'organizationalUnitName',
        'commonName',
        'emailAddress'
    ];

    private $information;
    private $privateKey;

    public function __construct(array $information = null, $privateKey = null, array $options = null)
    {

        $this->defineOptions([
            'encryptKey' => true,
            'privateKeyType' => OPENSSL_KEYTYPE_RSA,
            'digestAlgorithm' => 'sha512',
            'x509Extensions' => 'v3_ca',
            'privateKeyBits' => 4096,
            'configFile' => null
        ], $options);

        $this->information = $information ?: [];
        $this->privateKey = $privateKey ?: $this->generatePrivateKey();
    }

    /**
     * @return array
     */
    public function getInformation()
    {

        return $this->information;
    }

    /**
     * @param array $information
     *
     * @return $this
     */
    public function setInformation(array $information)
    {

        $this->information = $information;

        return $this;
    }

    private function getInternalOptions()
    {

        $options = [
            'encrypt_key' => $this->options['encryptKey'],
            'private_key_type' => $this->options['privateKeyType'],
            'digest_alg' => $this->options['digestAlgorithm'],
            'x509_extensions' => 'v3_ca',
            'private_key_bits' => $this->options['privateKeyBits']
        ];

        if ($this->options['configFile'])
            $options['config'] = $this->options['configFile'];

        return $options;
    }

    public function createHandle()
    {

        $this->validate();
        $result = openssl_csr_new($this->information, $this->privateKey, $this->getInternalOptions());

        if (!$result)
            throw new OpenSslException(
                "Failed to create CSR handle"
            );

        return $result;
    }

    private function generatePrivateKey()
    {

        return openssl_pkey_new($this->getInternalOptions());
    }

    public function has($key)
    {

        return isset($this->information[$key]);
    }

    public function get($key)
    {

        return $this->information[$key];
    }

    public function set($key, $value)
    {

        $this->information[$key] = $value;

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