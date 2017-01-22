<?php

namespace ParserBundle\Operation\Parse\ParsingStrategy;

use GuzzleHttp\Psr7\Request as HttpRequest;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Protocol\ProtocolInterface;
use ParserBundle\Internal\DataExtractor\DynamicDataExtractorInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\ParserConfig\ParserConfigInterface;

class ParseFromWebsiteStrategy implements ParsingStrategyInterface
{
    /**
     * @var ParserConfigInterface
     */
    private $parserConfig;

    /**
     * @var DynamicDataExtractorInterface
     */
    private $dataExtractor;

    /**
     * @var ProtocolInterface
     */
    private $protocol;

    /**
     * @param DynamicDataExtractorInterface $dataExtractor
     * @param ParserConfigInterface $parserConfig
     * @param ProtocolInterface $protocol
     */
    public function __construct(
        DynamicDataExtractorInterface $dataExtractor,
        ParserConfigInterface $parserConfig,
        ProtocolInterface $protocol
    ) {
        $this->dataExtractor = $dataExtractor;
        $this->parserConfig = $parserConfig;
        $this->protocol = $protocol;
    }

    /**
     * @param InternalRequestInterface|Request $request
     * @return array
     */
    public function parse(InternalRequestInterface $request): array
    {
        return
            $this->parseRecursively(
                $this->parserConfig->getMenu($request->getKey()),
                $request->getRootUrl()
            );
    }

    /**
     * @param array $parseConfig
     * @param string|null $rootUrl
     * @param string $partUrl
     * @return array
     */
    private function parseRecursively(array $parseConfig, string $rootUrl, string $partUrl = null): array
    {
        $parsed = [];

        if (!is_null($partUrl)) {
            $pageUrl = $this->resolveUrl($partUrl, $rootUrl);
        } else {
            $pageUrl = $rootUrl;
        }

        $html = $this->getPage($pageUrl);

        $parsed[$parseConfig['name']] = $this->dataExtractor->extract($html, $parseConfig['xpath']);

        if (array_key_exists('child_page', $parseConfig)) {
            foreach ($parsed[$parseConfig['name']] as $key => $element) {
                $parsedPage = $this->parseRecursively($parseConfig['child_page'], $rootUrl, $element['url']);
                $parsed[$parseConfig['name']][$key][] = $parsedPage;
            }
        }

        return $parsed;
    }

    /**
     * @param string $url
     * @return HttpRequest
     */
    private function createRequest(string $url): HttpRequest
    {
        return new HttpRequest('GET', $url);
    }

    /**
     * @param string $url
     * @return string
     */
    private function getPage(string $url): string
    {
        $response = $this->protocol->send($this->createRequest($url), []);

        return $response->getBody()->getContents();
    }

    /**
     * @param string $url
     * @param string $rootUrl
     * @return string
     */
    private function resolveUrl(string $url, string $rootUrl): string
    {
        return
            preg_match('/http(s)?:\/\//', $url)
                ? $url
                : rtrim($rootUrl, '/') . $url;
    }
}