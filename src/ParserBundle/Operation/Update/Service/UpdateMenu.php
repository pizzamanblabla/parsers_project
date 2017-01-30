<?php

namespace ParserBundle\Operation\Update\Service;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Entity\Source;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\EmptyInnerSuccessfulResponse;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\BaseEntityService;
use ParserBundle\Internal\Service\ServiceInterface;
use ParserBundle\Operation\Parse\Dto\Request;
use ParserBundle\Operation\Parse\Dto\SuccessfulResponse;
use ParserBundle\Operation\Update\Service\Exception\UnableToGetDataException;
use ParserBundle\Operation\Update\Transformer\FactoryInterface as TransformerFactoryInterface;
use Psr\Log\LoggerInterface;

class UpdateMenu extends BaseEntityService
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
     * @throws UnableToGetDataException
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        $internalResponse = $this->service->behave($request);

        if ($internalResponse->getType()->isErroneous()) {
            throw new UnableToGetDataException('Unable to get data for update');
        }

        $this->logger->info('Clearing previous menu');
        $this->clearMenu($this->getSource($request->getKey()));

        /** @var SuccessfulResponse $internalResponse */
        $this->structureAndPersistData(
            $internalResponse->getData(),
            ['source' => $this->getSource($request->getKey())]
        );

        return new EmptyInnerSuccessfulResponse();
    }

    /**
     * @param Source $source
     * @return void
     */
    private function clearMenu(Source $source)
    {
        $this->removeEntities($this->repositoryFactory->product()->findBySource($source));
        $this->removeEntities($this->repositoryFactory->category()->findBySource($source));
        $this->removeEntities($this->repositoryFactory->price()->findBySource($source));
        $this->removeEntities($this->repositoryFactory->picture()->findBySource($source));
    }

    /**
     * @param array $data
     * @param array $additionalData
     */
    private function structureAndPersistData(array $data, array $additionalData = [])
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
     * @return Source
     */
    private function getSource(string $key)
    {
        return $this->repositoryFactory->source()->findOneByKey($key);
    }

    /**
     * @param string $key
     * @return string
     */
    private function resolveKey(string $key): string
    {
        return
            array_key_exists($key, $this->keyMap)
                ? $this->keyMap[$key]
                : $key;
    }
}