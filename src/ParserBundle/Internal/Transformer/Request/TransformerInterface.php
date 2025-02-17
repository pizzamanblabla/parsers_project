<?php

namespace ParserBundle\Internal\Transformer\Request;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;

interface TransformerInterface
{
    /**
     * @param mixed $transformable
     * @return InternalRequestInterface
     */
    public function transform($transformable): InternalRequestInterface;
}