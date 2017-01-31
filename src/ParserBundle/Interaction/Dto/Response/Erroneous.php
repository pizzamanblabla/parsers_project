<?php

namespace ParserBundle\Interaction\Dto\Response;

use ParserBundle\Internal\Enum\ResponseType;

trait Erroneous
{
    /**
     * @return ResponseType
     */
    public function getType()
    {
        return ResponseType::erroneous();
    }
}