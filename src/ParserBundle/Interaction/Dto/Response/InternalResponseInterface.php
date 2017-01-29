<?php

namespace ParserBundle\Interaction\Dto\Response;

use ParserBundle\Internal\Enum\ResponseType;

interface InternalResponseInterface
{
    /**
     * @return ResponseType
     */
    public function getType();
}