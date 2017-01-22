<?php

namespace ParserBundle\Operation\Update\Service;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Repository\FactoryInterface as RepositoryFactoryInterface;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;
use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Internal\Service\BaseEntityService;
use ParserBundle\Internal\Service\ServiceInterface;
use Psr\Log\LoggerInterface;

class Service extends BaseEntityService
{
    /**
     * @var ServiceInterface
     */
    private $service;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RepositoryFactoryInterface $repositoryFactory
     * @param ServiceInterface $service
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RepositoryFactoryInterface $repositoryFactory,
        ServiceInterface $service,
        LoggerInterface $logger
    ) {
        parent::__construct($entityManager, $repositoryFactory, $logger);

        $this->service = $service;
    }

    /**
     * @param InternalRequestInterface $request
     * @return InternalResponseInterface
     */
    public function behave(InternalRequestInterface $request): InternalResponseInterface
    {
        $internalResponse = $this->service->behave($request);
    }
}