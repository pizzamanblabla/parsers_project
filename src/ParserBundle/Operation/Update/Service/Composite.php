<?php

namespace ParserBundle\Operation\Update\Service;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\ServiceInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Composite implements ServiceInterface
{
    use ContainerAwareTrait;

    /**
     * @param ServiceInterface[] $services
     */
    public function __construct(array $services)
    {
        $this->setContainer($services);
    }

    /**
     * @param InternalRequestInterface $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        // TODO: Implement behave() method.
    }
}