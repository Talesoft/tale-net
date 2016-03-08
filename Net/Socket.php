<?php

namespace Tale\Http;

use Tale\Http\TcpSocket\Exception;

class TcpSocket
{

    private $_socket;
    private $_bufferSize;
    private $_host;
    private $_port;

    public function __construct($host, $port, $bufferSize = null)
    {

        if (!filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) && !filter_var($host, FILTER_VALIDATE_IP, \FILTER_FLAG_IPV6))
            $host = gethostbyname($host);

        if (!$host)
            throw new Exception(
                "Failed to create socket: Invalid host $host passed or failed to look up DNS name"
            );

        if (!is_int($port))
            throw new Exception(
                "Failed to create socket: Port is not a valid port number"
            );

        $this->_socket = socket_create(\AF_INET, \SOCK_STREAM, \SOL_TCP);
        $this->_host = $host;
        $this->_port = $port;
        $this->_bufferSize = $bufferSize ? $bufferSize : 8192;
    }

    public function __destruct()
    {

        $this->shutDown()->close();
    }

    public function setOption($level, $option, $value)
    {

        if (socket_set_option($this->_socket, $level, $option, $value) === false)
            throw new Exception(
                "Failed to set socket option $option to $value: ".
                socket_strerror(socket_last_error())
            );

        return $this;
    }

    public function setSendTimeOut($seconds, $microSeconds = null)
    {

        $microSeconds = $microSeconds ? $microSeconds : 0;

        return $this->setOption(\SOL_SOCKET, \SO_SNDTIMEO, [
            'sec' => $seconds,
            'microseconds' => $microSeconds
        ]);
    }

    public function setReceiveTimeOut($seconds, $microSeconds = null)
    {

        $microSeconds = $microSeconds ? $microSeconds : 0;

        return $this->setOption(\SOL_SOCKET, \SO_RCVTIMEO, [
            'sec' => $seconds,
            'microseconds' => $microSeconds
        ]);
    }

    public function enableClientTls()
    {

        stream_socket_enable_crypto($this->_socket, true, \STREAM_CRYPTO_METHOD_TLS_CLIENT);

        return $this;
    }

    public function enableClientSsl()
    {

        stream_socket_enable_crypto($this->_socket, true, \STREAM_CRYPTO_METHOD_SSLv23_CLIENT);

        return $this;
    }

    public function enableServerTls()
    {

        stream_socket_enable_crypto($this->_socket, true, \STREAM_CRYPTO_METHOD_TLS_SERVER);

        return $this;
    }

    public function enableServerSsl()
    {

        stream_socket_enable_crypto($this->_socket, true, \STREAM_CRYPTO_METHOD_SSLv23_SERVER);

        return $this;
    }

    public function block()
    {

        socket_set_block($this->_socket);

        return $this;
    }

    public function unblock()
    {

        socket_set_nonblock($this->_socket);

        return $this;
    }

    public function bind()
    {

        if (!socket_bind($this->_socket, $this->_host, $this->_port))
            throw new Exception(
                "Failed to bind socket: ".socket_strerror(socket_last_error())
            );

        return $this;
    }

    public function connect()
    {

        if (!socket_connect($this->_socket, $this->_host, $this->_port))
            throw new Exception(
                "Failed to bind socket: ".socket_strerror(socket_last_error())
            );

        return $this;
    }

    public function shutDown()
    {

        if (is_resource($this->_socket))
            socket_shutdown($this->_socket);

        return $this;
    }

    public function close()
    {

        if (is_resource($this->_socket))
            socket_close($this->_socket);

        return $this;
    }

    public function read($length = null, &$readLength = null)
    {

        $length = $length ? $length : $this->_bufferSize;

        $buffer = '';
        $readLength = socket_recv($this->_socket, $buffer, $length, \MSG_WAITALL);

        if ($readLength === 0)
            throw new Exception(
                "Server unexpectedly closed connection"
            );

        if ($readLength === false)
            return null;

        return $buffer;
    }

    public function write($bytes)
    {

        $length = function_exists('mb_strlen') ? mb_strlen($bytes) : strlen($bytes);

        $writtenLength = null;
        if (($writtenLength = socket_send($this->_socket, $bytes, $length, 0)) === false)
            throw new Exception(
                "Failed to send data: ".socket_strerror(socket_last_error())
            );

        return $writtenLength;
    }
}