<?php

namespace ParserBundle\Interaction\Dto\Response;

use ParserBundle\Internal\Enum\ResponseType;

trait Successful
{
    /**
     * @return ResponseType
     */
    public function getType()
    {
        return ResponseType::successful();
    }
}