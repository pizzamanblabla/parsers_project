<?php

namespace ParserBundle\Internal\DataExtractor;

interface DynamicDataExtractorInterface
{
    /**
     * @param mixed $extractable
     * @param array $config
     * @return mixed
     */
    public function extract($extractable, $config);
}