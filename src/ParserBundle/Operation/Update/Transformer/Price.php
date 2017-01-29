<?php

namespace ParserBundle\Operation\Update\Transformer;

use ParserBundle\Entity\Price as PriceEntity;

class Price implements ArrayToEntityTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $data)
    {
        return
            (new PriceEntity())
                ->setProduct($data['product'])
                ->setValue($data['price'])
            ;
    }
}