<?php

namespace ParserBundle\Internal\Service;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;

interface ServiceInterface
{
    /**
     * @param InternalRequestInterface $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface;
}