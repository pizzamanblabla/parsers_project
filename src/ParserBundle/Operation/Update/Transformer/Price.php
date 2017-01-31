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

        if (empty($data["price"])) {
            $oldPrice = $data["price_with_discount"];
        } else {
            $oldPrice = $data["price"];
        }

        return
            (new PriceEntity())
                ->setProduct($data['product'])
                ->setValue($data["price_with_discount"])
                ->setOldValue($oldPrice)
                ->setHasDiscount($isDiscount)
                ->setDate(new \DateTime())
            ;
    }
}