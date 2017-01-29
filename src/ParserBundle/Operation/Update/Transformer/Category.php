<?php

namespace ParserBundle\Operation\Update\Transformer;

use ParserBundle\Entity\Category as CategoryEntity;

class Category implements ArrayToEntityTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $data)
    {
        $category = new CategoryEntity();

        $category
            ->setName($data['name'])
            ->setUrl($data['url'])
            ->setSource($data['source'])
        ;

        if (isset($data['category'])) {
            $category->setParentCategory($data['category']);
        }

        return $category;
    }
}