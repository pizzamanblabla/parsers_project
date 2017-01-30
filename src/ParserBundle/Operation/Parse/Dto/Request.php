<?php

namespace ParserBundle\Operation\Parse\Dto;

use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;

class Request implements InternalRequestInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $rootUrl;

    /**
     * @var string[]
     */
    private $parsingMap;

    /**
     * @var string
     */
    private $updateType;

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

    /**
     * @return \string[]
     */
    public function getParsingMap()
    {
        return $this->parsingMap;
    }

    /**
     * @param \string[] $parsingMap
     * @return Request
     */
    public function setParsingMap(array $parsingMap)
    {
        $this->parsingMap = $parsingMap;
        return $this;
    }

    /**
     * @return string
     */
    public function getUpdateType()
    {
        return $this->updateType;
    }

    /**
     * @param string $updateType
     * @return Request
     */
    public function setUpdateType($updateType)
    {
        $this->updateType = $updateType;
        return $this;
    }
}