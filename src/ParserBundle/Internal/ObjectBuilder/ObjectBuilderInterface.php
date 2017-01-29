<?php

namespace ParserBundle\Internal\ObjectBuilder;

interface ObjectBuilderInterface
{
    /**
     * @param object $object
     * @param string $objectFormType
     * @param mixed[] $data
     * @return mixed
     */
    public function build($object, $objectFormType, array $data);
}