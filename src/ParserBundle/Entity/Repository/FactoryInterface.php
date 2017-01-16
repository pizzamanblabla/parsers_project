<?php

namespace ParserBundle\Entity\Repository;

interface FactoryInterface
{
    /**
     * @return Category
     */
    public function category(): Category;

    /**
     * @return Picture
     */
    public function picture(): Picture;

    /**
     * @return Price
     */
    public function price(): Price;

    /**
     * @return Product
     */
    public function product(): Product;

    /**
     * @return Source
     */
    public function source(): Source;
}