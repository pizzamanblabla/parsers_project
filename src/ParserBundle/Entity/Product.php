<?php

namespace ParserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="ParserBundle\Entity\Repository\Product")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="products_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private $name;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=128, nullable=false)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=512, nullable=false)
     */
    private $description;

    /**
     * @var mixed[]
     *
     * @ORM\Column(name="characteristics", type="jsonb")
     */
    private $characteristics = [];

    /**
     * @var ArrayCollection|Product[]
     *
     * @ORM\ManyToMany(targetEntity="Product", orphanRemoval=true)
     * @ORM\JoinTable(name="also_buy", joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="also_buy_product_id", referencedColumnName="id")})
     */
    private $alsoBuyProducts;

    /**
     * @var ArrayCollection|Product[]
     *
     * @ORM\ManyToMany(targetEntity="Product", orphanRemoval=true)
     * @ORM\JoinTable(name="similar_products", joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}, inverseJoinColumns={@ORM\JoinColumn(name="similar_product_id", referencedColumnName="id")})
     */
    private $similarProducts;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @param array $characteristics
     * @return $this
     */
    public function setCharacteristics($characteristics)
    {
        $this->characteristics = $characteristics;
        return $this;
    }

    /**
     * @return Product[]
     */
    public function getAlsoBuyProducts()
    {
        return $this->alsoBuyProducts;
    }

    /**
     * @param Product[] $alsoBuyProducts
     * @return $this
     */
    public function setAlsoBuyProducts($alsoBuyProducts)
    {
        $this->alsoBuyProducts = $alsoBuyProducts;
        return $this;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function addAlsoBuyProduct(Product $product)
    {
        $this->alsoBuyProducts->add($product);

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function removeAlsoBuyProduct(Product $product)
    {
        $this->alsoBuyProducts->removeElement($product);

        return $this;
    }

    /**
     * @return Product[]
     */
    public function getSimilarProducts()
    {
        return $this->similarProducts;
    }

    /**
     * @param Product[] $similarProducts
     * @return $this
     */
    public function setSimilarProducts($similarProducts)
    {
        $this->similarProducts = $similarProducts;
        return $this;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function addSimilarProduct(Product $product)
    {
        $this->similarProducts->add($product);

        return $this;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function removeSimilarProduct(Product $product)
    {
        $this->similarProducts->removeElement($product);

        return $this;
    }
}