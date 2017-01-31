<?php

namespace ParserBundle\Interaction\Dto\Response;

class EmptyInnerErroneousResponse implements InternalResponseInterface
{
    use Erroneous;
}