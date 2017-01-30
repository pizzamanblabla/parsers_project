<?php

namespace ParserBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="prices")
 * @ORM\Entity(repositoryClass="ParserBundle\Entity\Repository\Price")
 */
class Price
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="prices_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="string", length=128, nullable=false)
     */
    private $value;

    /**
     * @var float
     *
     * @ORM\Column(name="old_value", type="string", length=128)
     */
    private $oldValue;

    /**
     * @var bool
     *
     * @ORM\Column(name="has_discount", type="boolean")
     */
    private $hasDiscount;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetimetz", length=128, nullable=false)
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Price
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return Price
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Price
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @param float $oldValue
     * @return Price
     */
    public function setOldValue($oldValue)
    {
        $this->oldValue = $oldValue;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasDiscount()
    {
        return $this->hasDiscount;
    }

    /**
     * @param boolean $hasDiscount
     * @return Price
     */
    public function setHasDiscount($hasDiscount)
    {
        $this->hasDiscount = $hasDiscount;
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
     * @return Price
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}