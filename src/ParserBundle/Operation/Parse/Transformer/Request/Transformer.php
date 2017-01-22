<?php

namespace ParserBundle\Operation\Parse\Transformer\Request;

use ParserBundle\Entity\Exception\SourceNotFoundException;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Entity\Source;
use ParserBundle\Internal\Exception\UnexpectedTypeException;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Internal\Transformer\Request\TransformerInterface;
use ParserBundle\Operation\Parse\Dto\Request;

class Transformer implements TransformerInterface
{
    /**
     * @var RepositoryFactoryInterface
     */
    private $repositoryFactory;

    /**
     * @param RepositoryFactoryInterface $repositoryFactory
     */
    public function __construct(RepositoryFactoryInterface $repositoryFactory)
    {
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * @param $transformable
     * @return InternalRequestInterface
     * @throws UnexpectedTypeException
     * @throws SourceNotFoundException
     */
    public function transform($transformable): InternalRequestInterface
    {
        if (!assert(is_string($transformable))) {
            throw new UnexpectedTypeException('Unexpected type of variable');
        }

        $source = $this->repositoryFactory->source()->findOneByKey($transformable);

        if (is_null($source)) {
            throw new SourceNotFoundException(sprintf('Source not found by key: %s', $transformable));
        }

        return $this->createRequest($source);
    }

    /**
     * @param Source $source
     * @return Request
     */
    private function createRequest(Source $source)
    {
        return
            (new Request())
                ->setId($source->getId())
                ->setKey($source->getKey())
                ->setRootUrl($source->getRootUrl())
            ;
    }
}