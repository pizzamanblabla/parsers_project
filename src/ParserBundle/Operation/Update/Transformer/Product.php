<?php

namespace ParserBundle\Operation\Update\Transformer;

use ParserBundle\Entity\Product as ProductEntity;

class Product implements ArrayToEntityTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $data)
    {
        return
            (new ProductEntity())
                ->setName($data['name'])
                ->setUrl($data['url'])
                ->setCategory($data['category'])
            ;
    }
}