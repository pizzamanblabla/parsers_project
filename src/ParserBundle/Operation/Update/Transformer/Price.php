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
        if (intval($data["price_with_discount"]) != $data["price"]) {
            $isDiscount = true;
        } else {
            $isDiscount = false;
        }

        return
            (new PriceEntity())
                ->setProduct($data['product'])
                ->setValue(intval($data["price_with_discount"]))
                ->setOldValue($data["price"])
                ->setHasDiscount($isDiscount)
                ->setDate(new \DateTime())
            ;
    }
}