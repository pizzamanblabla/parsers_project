<?php

namespace ParserBundle\Operation\Parse\DataExtractor;

use DOMXPath;
use DOMNode;
use DOMNodeList;
use ParserBundle\Internal\DataExtractor\BaseHtmlToArrayDataExtractor;
use ParserBundle\Internal\DataExtractor\DynamicDataExtractorInterface;

class HtmlToArrayDataExtractor extends BaseHtmlToArrayDataExtractor implements DynamicDataExtractorInterface
{
    /**
     * @param string $extractable
     * @param array $config
     * @return string[]
     */
    public function extract($extractable, $config)
    {
        $xpath = $this->buildXpathFromHtml($extractable);
        $extracted = [];

        if (array_key_exists('group', $config)) {
            $group = $this->extractGroup($config['group'], $xpath);

            foreach ($group as $element) {
                $extracted[] = $this->extractNodes($config['to_parse'], $xpath, $element);
            }
        } else {
            $extracted[] = $this->extractNodes($config['to_parse'], $xpath);
        }

        return $extracted;
    }

    /**
     * @param string|string[] $params
     * @param DOMXPath $xpath
     * @param DOMNode|null $parentNode
     * @return string[]
     */
    private function extractNodes($params, DOMXPath $xpath, DOMNode $parentNode = null)
    {
        $extracted = [];

        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $extracted[$key] = $this->extractNodes($value, $xpath);
            } else {

                $extractedValues = $this->extractGroup($value, $xpath, $parentNode);

                if ($extractedValues->length) {
                    $extracted[$key] = $extractedValues->item(0)->textContent;
                }
            }
        }

        return $extracted;
    }

    /**
     * @param string $path
     * @param DOMXPath $xpath
     * @param DOMNode|null $parentNode
     * @return DOMNodeList
     */
    private function extractGroup(string $path, DOMXPath $xpath, DOMNode $parentNode = null)
    {
        return
            is_null($parentNode)
                ? $xpath->query($path)
                : $xpath->query($path, $parentNode)
            ;
    }
}