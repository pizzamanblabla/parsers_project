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
use ParserBundle\Operation\Parse\Dto\SuccessfulResponse;
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
     * @var array
     */
    private $keyMap = [
        'categories' => 'category',
        'sub_categories' => 'category',
        'product' => 'product',
        'images_all' => 'picture',
        'prices' => 'price',
        'similar_products_all' => 'similar_products_all',
        'also_products_all' => 'also_products_all'
    ];

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
            function(Product $product) use ($request) {
                $response = $this->service->behave($this->transformRequest($request, $product->getUrl()));

                if ($response->getType()->isSuccessful()) {
                    /** @var $response SuccessfulResponse */
                    $this->removeProductDetails($product);
                    $this->updateProduct($product, $response->getData());
                } else {
                    $this->logger->warning(sprintf('Product updating skipped id:%s', $product->getId()));
                }
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
     * @param Product $product
     * @return void
     */
    private function removeProductDetails(Product $product)
    {
        $pictures = $this->repositoryFactory->picture()->findByProduct($product);
        $prices = $this->repositoryFactory->price()->findByProduct($product);
        $this->removeEntities($pictures);
        $this->removeEntities($prices);

//        foreach ($product->getAlsoBuyProducts() as $alsoProduct) {
//            $product->removeAlsoBuyProduct($alsoProduct);
//        }
//
//        foreach ($product->getSimilarProducts() as $similarProduct) {
//            $product->removeAlsoBuyProduct($similarProduct);
//        }
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

    /**
     * @param Product $product
     * @param array $data
     * @return void
     */
    private function updateProduct(Product $product, array $data)
    {
        if (isset($data['product'][0]['description'])) {
            $product->setDescription($data['product'][0]['description']);
        }

        $product->setCharacteristics($this->getCharacteristicsFromData($data['product'][0]));
        $this->setProductEntities($product, $data['product'][0]);
    }

    /**
     * @param array $data
     * @return array
     */
    private function getCharacteristicsFromData(array $data): array
    {
        $characteristics = [];

        foreach ($data as $key => $element) {
            if (!is_array($element) && $key != 'description') {
                $characteristics[$key] = $element;
            }
        }

        return $characteristics;
    }

    /**
     * @param Product $product
     * @param array $data
     */
    private function setProductEntities(Product $product, array $data)
    {
        foreach ($data as $key => $element) {
            if (is_array($element) && array_key_exists($key, $this->keyMap)) {
                if (preg_match('/similar_products_all/ui', $key)) {
                    array_map(
                        function($data) use ($product) {
                            $entity = $this->repositoryFactory->product()->findOneByUrl($data);

                            if (!is_null($entity)) {
                                $product->addSimilarProduct($entity);
                            }
                        },
                        $element
                    );
                } elseif (preg_match('/also_products_all/ui', $key)) {
                    array_map(
                        function($data) use ($product) {
                            $entity = $this->repositoryFactory->product()->findOneByUrl($data);

                            if (!is_null($entity)) {
                                $product->addAlsoBuyProduct($entity);
                            }
                        },
                        $element
                    );
                } elseif (preg_match('/_all/ui', $key)) {
                    $transformer = $this->transformerFactory->spawn($this->keyMap[$key]);

                    array_map(
                        function ($data) use ($transformer, $product) {
                            $entity = $transformer->transform(['product' => $product, 'url' => $data]);
                            $this->entityManager->persist($entity);
                        },
                        $element
                    );
                } else {
                    $transformer = $this->transformerFactory->spawn($this->keyMap[$key]);
                    $entity = $transformer->transform(array_merge(['product' => $product], $element));
                    $this->entityManager->persist($entity);
                }
            }
        }
    }
}