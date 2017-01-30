<?php

namespace ParserBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use ParserBundle\Entity\Source as EntitySource;

/**
 * @method findByProduct($product)
 */
class Picture extends EntityRepository
{
    /**
     * @param EntitySource $source
     * @return Product[]
     */
    public function findBySource(EntitySource $source)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder
            ->leftJoin('p.product','pr')
            ->leftJoin('pr.category','c')
            ->leftJoin('c.source', 's')
            ->where('s.id=:source')
            ->setParameter('source', $source->getId())
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}