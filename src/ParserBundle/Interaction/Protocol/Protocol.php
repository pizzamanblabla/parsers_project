<?php

namespace ParserBundle\Interaction\Protocol;

use GuzzleHttp\Client;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class Protocol implements ProtocolInterface
{
    use LoggerAwareTrait;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     * @param LoggerInterface $logger
     */
    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->setLogger($logger);

        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function send(RequestInterface $request, array $options)
    {
        $response =  $this->client->send(
            $request,
            $options
        );

        if ($response->getStatusCode() != 200) {
            $this->logger->notice(
                sprintf(
                    'Wrong https status: %s on url: %s',
                    $response->getStatusCode(),
                    $request->getUri()->getPath()
                )
            );
        }

        return $response;
    }
}