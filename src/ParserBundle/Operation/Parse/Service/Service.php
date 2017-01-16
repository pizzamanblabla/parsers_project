<?php

namespace ParserBundle\Operation\Parse\Service;

use ParserBundle\Internal\Request\InternalRequestInterface;
use ParserBundle\Internal\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Operation\Parse\Dto\Request;

class Service implements ServiceInterface
{
    /**
     * @param InternalRequestInterface|Request $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        // TODO: Implement behave() method.
    }
}