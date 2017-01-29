<?php

namespace ParserBundle\Operation\Update\Transformer;

interface ArrayToEntityTransformerInterface
{
    /**
     * @param array $transform
     * @return mixed
     * @throws UnableToTransformEntityException
     */
    public function transform(array $transform);
}