<?php

namespace ParserBundle\Internal\Transformer\Request;

use ParserBundle\Internal\Request\InternalRequestInterface;
use ParserBundle\Internal\Response\InternalResponseInterface;

interface InternalResponseToRequestTransformerInterface
{
    /**
     * @param InternalResponseInterface $response
     * @return InternalRequestInterface
     */
    public function transform(InternalResponseInterface $response): InternalRequestInterface;
}