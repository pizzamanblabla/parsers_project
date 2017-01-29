<?php

namespace ParserBundle\Operation\Update\Service;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Operation\Update\Transformer\FactoryInterface as TransformerFactoryInterface;
use ParserBundle\Internal\Service\BaseEntityService;
use ParserBundle\Internal\Service\ServiceInterface;
use Psr\Log\LoggerInterface;

class UpdateProducts extends BaseEntityService
{
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
     * @param InternalRequestInterface $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        // TODO: Implement behave() method.
    }
}