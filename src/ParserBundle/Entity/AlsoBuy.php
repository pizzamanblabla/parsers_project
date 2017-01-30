<?php

namespace ParserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Table(name="also_buy")
 * @ORM\Entity(repositoryClass="ParserBundle\Entity\Repository\AlsoBuy")
 */
class AlsoBuy
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var Product
     */
    private $alsoBuyProduct;

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
     * @return AlsoBuy
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return Product
     */
    public function getAlsoBuyProduct()
    {
        return $this->alsoBuyProduct;
    }

    /**
     * @param Product $alsoBuyProduct
     * @return AlsoBuy
     */
    public function setAlsoBuyProduct($alsoBuyProduct)
    {
        $this->alsoBuyProduct = $alsoBuyProduct;
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
     * @return AlsoBuy
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}