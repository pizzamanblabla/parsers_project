<?php

namespace ParserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="similar_products")
 * @ORM\Entity(repositoryClass="ParserBundle\Entity\Repository\SimilarProducts")
 */
class SimilarProducts
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var Product
     */
    private $similarProduct;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return SimilarProducts
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return Product
     */
    public function getSimilarProduct()
    {
        return $this->similarProduct;
    }

    /**
     * @param Product $similarProduct
     * @return SimilarProducts
     */
    public function setSimilarProduct($similarProduct)
    {
        $this->similarProduct = $similarProduct;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return SimilarProducts
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}