<?php

namespace ParserBundle\Interaction\Protocol;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ProtocolInterface
{
    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options);
}