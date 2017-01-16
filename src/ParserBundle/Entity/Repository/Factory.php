<?php

namespace ParserBundle\Entity\Repository;

use Doctrine\ORM\EntityManagerInterface;
use ParserBundle\Entity\Category as CategoryEntity;
use ParserBundle\Entity\Picture as PictureEntity;
use ParserBundle\Entity\Price as PriceEntity;
use ParserBundle\Entity\Product as ProductEntity;
use ParserBundle\Entity\Source as SourceEntity;

class Factory implements FactoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Category
     */
    public function category(): Category
    {
        return $this->entityManager->getRepository(CategoryEntity::class);
    }

    /**
     * @return Picture
     */
    public function picture(): Picture
    {
        return $this->entityManager->getRepository(PictureEntity::class);
    }

    /**
     * @return Price
     */
    public function price(): Price
    {
        return $this->entityManager->getRepository(PriceEntity::class);
    }

    /**
     * @return Product
     */
    public function product(): Product
    {
        return $this->entityManager->getRepository(ProductEntity::class);
    }

    /**
     * @return Source
     */
    public function source(): Source
    {
        return $this->entityManager->getRepository(SourceEntity::class);
    }
}