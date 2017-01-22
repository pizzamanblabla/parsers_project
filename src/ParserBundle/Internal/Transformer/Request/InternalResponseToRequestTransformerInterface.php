<?php

namespace ParserBundle\Internal\Transformer\Request;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;

interface InternalResponseToRequestTransformerInterface
{
    /**
     * @param InternalResponseInterface $response
     * @return InternalRequestInterface
     */
    public function transform(InternalResponseInterface $response): InternalRequestInterface;
}