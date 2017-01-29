<?php

namespace ParserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use ParserBundle\Entity\Source;

/**
 * @method findByUrl($url)
 */
class Product extends EntityRepository
{
    /**
     * @param Source $source
     * @return Product[]
     */
    public function findBySource(Source $source)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->leftJoin('p.category','c')
            ->leftJoin('c.source', 's')
            ->where('s.id=:source')
            ->setParameter('source', $source->getId())
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}