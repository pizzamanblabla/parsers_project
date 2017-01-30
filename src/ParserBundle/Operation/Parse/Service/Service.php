<?php

namespace ParserBundle\Operation\Parse\Service;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\Operation\Parse\Dto\SuccessfulResponse;
use ParserBundle\Operation\Parse\ParsingStrategy\ParsingStrategyInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class Service implements ServiceInterface
{
    use LoggerAwareTrait;

    /**
     * @var ParsingStrategyInterface
     */
    private $strategy;

    /**
     * @param ParsingStrategyInterface $strategy
     * @param LoggerInterface $logger
     */
    public function __construct(ParsingStrategyInterface $strategy, LoggerInterface $logger)
    {
        $this->setLogger($logger);

        $this->strategy = $strategy;
    }

    /**
     * @param InternalRequestInterface|Request $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        $this->logger->info('Begin parsing');
        $parsed = $this->strategy->parse($request);

        if (!is_array($parsed) || empty($parsed)) {
            $this->logger->warning('Parsing failed');
        }

        return (new SuccessfulResponse())->setData($parsed);
    }
}