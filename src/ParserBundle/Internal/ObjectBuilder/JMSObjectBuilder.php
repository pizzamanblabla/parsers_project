<?php

namespace ParserBundle\Internal\ObjectBuilder;

use JMS\Serializer\Serializer;
use Psr\Log\LoggerInterface;
use Exception;

class JMSObjectBuilder implements ObjectBuilderInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Serializer $serializer
     * @param LoggerInterface $logger
     */
    public function __construct(Serializer $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function build($object, $objectFormType, array $data)
    {
        try {
            return $this->serializer->fromArray($data, get_class($object));
        } catch (Exception $e) {
            $this->logger->warning(
                "Could not build object: '{error}'",
                [
                    'exception' => $e,
                    'error' => $e->getMessage()
                ]
            );

            return $object;
        }
    }
}