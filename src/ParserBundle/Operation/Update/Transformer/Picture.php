<?php

namespace ParserBundle\Operation\Update\Transformer;

use ParserBundle\Entity\Picture as PictureEntity;

class Picture implements ArrayToEntityTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform(array $data)
    {
        return
            (new PictureEntity())
                ->setProduct($data['product'])
                ->setUrl($data['url'])
            ;
    }
}