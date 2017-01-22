<?php

namespace ParserBundle\ParserConfig;

interface ParserConfigInterface
{
    /**
     * @param $sourceKey
     * @return array
     */
    public function getMenu($sourceKey): array;
}