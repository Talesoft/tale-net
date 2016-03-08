<?php

namespace Tale\Net;

use InvalidArgumentException;
use RuntimeException;
use Tale\Stream;

/**
 * Class Stream
 *
 * @package Tale\Net
 */
class SocketBase extends Stream
{

    /**
     * Stream constructor.
     *
     * @param resource $context
     */
    public function __construct($context)
    {

        if (!is_resource($context) || get_resource_type($context) !== 'stream')
            throw new InvalidArgumentException(
                "Failed to create socket: Passed resource is not a valid stream ".
                "resource"
            );

        parent::__construct($context);
    }

    public function shutdown($how = null)
    {

        $how = $how ?: STREAM_SHUT_RDWR;
        stream_socket_shutdown($this->getContext(), $how);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {

        if (!$this->getContext())
            return;

        $this->shutdown();
        parent::close();
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {

        if (!$this->isReadable())
            throw new RuntimeException(
                "Stream is not readable"
            );

        return stream_socket_recvfrom($this->getContext(), $length);
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {

        if (!$this->isWritable())
            throw new RuntimeException(
                "Stream is not writable"
            );

        return stream_socket_sendto($this->getContext(), $string);
    }
}