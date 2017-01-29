<?php

namespace ParserBundle\ParserConfig;

use ParserBundle\ParserConfig\Exception\MissedElementException;
use ParserBundle\ParserConfig\Exception\SourceNotFoundException;

class ParserConfig implements ParserConfigInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getMenu($sourceKey): array
    {
        return $this->getValueOrThrowException($this->getConfig($sourceKey), 'menu');
    }

    /**
     * {@inheritdoc}
     */
    public function getProduct($sourceKey): array
    {
        return $this->getValueOrThrowException($this->getConfig($sourceKey), 'product');
    }

    /**
     * @param $sourceKey
     * @return mixed
     * @throws SourceNotFoundException
     */
    private function getConfig($sourceKey)
    {
        if (!array_key_exists($sourceKey, $this->config)) {
            throw new SourceNotFoundException(sprintf('Source with key \'%s\' not found', $sourceKey));
        }

        return $this->config[$sourceKey];
    }

    /**
     * @param array $container
     * @param string $key
     * @param mixed $else
     * @return mixed
     */
    protected function getValueOrElse(array $container, $key, $else)
    {
        if (array_key_exists($key, $container)) {
            return $container[$key];
        }

        return $else;
    }

    /**
     * @param array $container
     * @param $key
     * @return mixed
     * @throws MissedElementException
     */
    protected function getValueOrThrowException(array $container, $key)
    {
        if (array_key_exists($key, $container)) {
            return $container[$key];
        }

        throw new MissedElementException(sprintf('Required parameter \'%s\' is missing', $key));
    }
}