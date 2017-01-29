<?php

namespace ParserBundle\Operation\Update\Transformer;

interface FactoryInterface
{
    /**
     * @param string $key
     * @return ArrayToEntityTransformerInterface
     */
    public function spawn($key);
}