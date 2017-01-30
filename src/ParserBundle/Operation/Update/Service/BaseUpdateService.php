<?php

namespace ParserBundle\Operation\Update\Service;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Internal\Service\BaseEntityService;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Operation\Update\Transformer\FactoryInterface as TransformerFactoryInterface;
use Psr\Log\LoggerInterface;

abstract class BaseUpdateService extends BaseEntityService
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
    protected $keyMap = [
        'categories' => 'category',
        'sub_categories' => 'category',
        'product' => 'product',
    ];

    /**
     * @param EntityManagerInterface $entityManager
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param ServiceInterface $service
     * @param TransformerFactoryInterface $transformerFactory
     * @param array $keyMap
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RepositoryFactoryInterface $repositoryFactory,
        ServiceInterface $service,
        TransformerFactoryInterface $transformerFactory,
        array $keyMap,
        LoggerInterface $logger
    ) {
        parent::__construct($entityManager, $repositoryFactory, $logger);

        $this->service = $service;
        $this->transformerFactory = $transformerFactory;
        $this->keyMap = $keyMap;
    }

    /**
     * @param array $data
     * @param array $additionalData
     */
    protected function structureAndPersistData(array $data, array $additionalData = [])
    {
        foreach ($data as $key => $element) {
            if (is_array($element) && array_key_exists($key, $this->keyMap)) {
                $transformer = $this->transformerFactory->spawn($key);

                array_map(
                    function($element) use ($transformer, $additionalData, $key) {
                        $entity = $transformer->transform(array_merge($element, $additionalData));
                        $this->entityManager->persist($entity);

                        $this->structureAndPersistData(
                            $element,
                            array_merge([$this->resolveKey($key) => $entity], $additionalData)
                        );

                        return $entity;
                    },
                    $element
                );
            }
        }
    }

    /**
     * @param string $key
     * @return string
     */
    protected function resolveKey(string $key): string
    {
        return
            array_key_exists($key, $this->keyMap)
                ? $this->keyMap[$key]
                : $key;
    }
}