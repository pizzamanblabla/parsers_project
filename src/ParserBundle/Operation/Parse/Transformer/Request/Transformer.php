<?php

namespace ParserBundle\Operation\Parse\Transformer\Request;

use ParserBundle\Entity\Exception\SourceNotFoundException;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Entity\Source;
use ParserBundle\Internal\Exception\UnexpectedTypeException;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Internal\Transformer\Request\TransformerInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\ParserConfig\ParserConfigInterface;

class Transformer implements TransformerInterface
{
    /**
     * @var RepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * @var ParserConfigInterface
     */
    private $parserConfig;

    /**
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param ParserConfigInterface $parserConfig
     */
    public function __construct(RepositoryFactoryInterface $repositoryFactory, ParserConfigInterface $parserConfig)
    {
        $this->repositoryFactory = $repositoryFactory;
        $this->parserConfig = $parserConfig;
    }

    /**
     * @param $transformable
     * @return InternalRequestInterface
     * @throws UnexpectedTypeException
     * @throws SourceNotFoundException
     */
    public function transform($transformable): InternalRequestInterface
    {
        if (!assert(is_array($transformable))) {
            throw new UnexpectedTypeException('Unexpected type of variable');
        }

        $source = $this->repositoryFactory->source()->findOneByKey($transformable['key']);

        if (is_null($source)) {
            throw new SourceNotFoundException(sprintf('Source not found by key: %s', $transformable));
        }

        return $this->createRequest($source, $this->getParsingMap($transformable['product'], $transformable['key']));
    }

    /**
     * @param Source $source
     * @param array $map
     * @return Request
     */
    private function createRequest(Source $source, array $map): Request
    {
        return
            (new Request())
                ->setId($source->getId())
                ->setKey($source->getKey())
                ->setRootUrl($source->getRootUrl())
                ->setParsingMap($map)
            ;
    }

    /**
     * @param bool $isProductCommand
     * @param string $key
     * @return array
     */
    private function getParsingMap(bool $isProductCommand, string $key): array
    {
        return $isProductCommand ? $this->parserConfig->getProduct($key) : $this->parserConfig->getMenu($key);
    }
}