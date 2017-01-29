<?php

namespace ParserBundle\Operation\Update\Service;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Product;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Entity\Source;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\EmptyInnerSuccessfulResponse;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\Operation\Update\Transformer\FactoryInterface as TransformerFactoryInterface;
use ParserBundle\Internal\Service\BaseEntityService;
use ParserBundle\Internal\Service\ServiceInterface;
use Psr\Log\LoggerInterface;

class UpdateProducts extends BaseEntityService
{
    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * @var TransformerFactoryInterface
     */
    private $transformerFactory;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param ServiceInterface $service
     * @param TransformerFactoryInterface $transformerFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RepositoryFactoryInterface $repositoryFactory,
        ServiceInterface $service,
        TransformerFactoryInterface $transformerFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($entityManager, $repositoryFactory, $logger);

        $this->service = $service;
        $this->transformerFactory = $transformerFactory;
    }

    /**
     * @param InternalRequestInterface|Request $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        array_map(
            function(Product $product) use ($request){
                $response = $this->service->behave($this->transformRequest($request, $product->getUrl()));

                var_dump($response);die;
            },
            $this->repositoryFactory->product()->findBySource($this->getSource($request->getKey()))
        );

        return new EmptyInnerSuccessfulResponse();
    }

    /**
     * @param string $key
     * @return Source|null
     */
    private function getSource(string $key)
    {
        return $this->repositoryFactory->source()->findOneByKey($key);
    }

    /**
     * @param InternalRequestInterface|Request $request
     * @param string $url
     * @return Request
     */
    private function transformRequest(InternalRequestInterface $request, string $url): Request
    {
        return
            (new Request())
            ->setParsingMap($request->getParsingMap())
            ->setId($request->getId())
            ->setKey($request->getKey())
            ->setRootUrl($this->resolveUrl($url, $request->getRootUrl()))
            ;
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