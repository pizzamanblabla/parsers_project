<?php

namespace ParserBundle\Internal\Service;

use ParserBundle\Internal\Request\InternalRequestInterface;
use ParserBundle\Internal\Response\InternalResponseInterface;

interface ServiceInterface
{
    /**
     * @param InternalRequestInterface $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface;
}