<?php

namespace ParserBundle\Operation\Parse\ParsingStrategy;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;

interface ParsingStrategyInterface
{
    /**
     * @param InternalRequestInterface $request
     * @return array
     */
    public function parse(InternalRequestInterface $request): array;
}