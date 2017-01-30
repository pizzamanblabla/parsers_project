<?php

namespace ParserBundle\Operation\Update\Service;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\Operation\Update\Service\Exception\UndefinedUpdateTypeException;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ResolverServiceDecorator implements ServiceInterface
{
    /**
     * @var ServiceInterface[]
     */
    private $services;

    /**
     * @param ServiceInterface[] $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * @param InternalRequestInterface|Request $request
     * @return InternalResponseInterface
     * @throws UndefinedUpdateTypeException
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        if (array_key_exists($request->getUpdateType(), $this->services)) {
            return $this->services[$request->getUpdateType()]->behave($request);
        }

        throw new UndefinedUpdateTypeException(sprintf('Cannot find service for update type: %s', $request->getUpdateType()));
    }
}