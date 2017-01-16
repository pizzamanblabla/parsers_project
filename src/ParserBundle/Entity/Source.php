<?php

namespace ParserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="sources")
 * @ORM\Entity(repositoryClass="ParserBundle\Entity\Repository\Source")
 */
class Source
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="sources_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=128, nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=128, nullable=false)
     */
    private $rootUrl;

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
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getRootUrl()
    {
        return $this->rootUrl;
    }

    /**
     * @param string $rootUrl
     * @return $this
     */
    public function setRootUrl($rootUrl)
    {
        $this->rootUrl = $rootUrl;
        return $this;
    }

}