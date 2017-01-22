<?php

namespace ParserBundle\Internal\DataExtractor;

use DOMXPath;
use DOMDocument;

abstract class BaseHtmlToArrayDataExtractor
{
    /**
     * @param string $html
     * @return DOMXPath
     */
    protected function buildXpathFromHtml(string $html): DOMXPath
    {
        libxml_use_internal_errors(true);

        $dom = new DomDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->encoding = 'UTF-8';
        $dom->loadHTML($html);

        return new DOMXPath($dom);
    }
}