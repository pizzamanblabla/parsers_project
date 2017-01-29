<?php

namespace ParserBundle\Operation\Update\Transformer;

use ParserBundle\Operation\Update\Transformer\Exception\TransformerNotExists;

class Factory implements FactoryInterface
{
    /**
     * @var string[]
     */
    private $keyMap = [];

    /**
     * @param string[] $keyMap
     */
    public function __construct(array $keyMap)
    {
        $this->keyMap = $keyMap;
    }

    /**
     * {@inheritdoc}
     */
    public function spawn($key)
    {
        if (array_key_exists($key, $this->keyMap)) {
            return call_user_func([$this, $this->keyMap[$key]]);
        }

        throw new TransformerNotExists(sprintf('Cannot find transformer by key: %s', $key));
    }

    /**
     * @return ArrayToEntityTransformerInterface
     */
    private function category()
    {
        return new Category();
    }

    /**
     * @return ArrayToEntityTransformerInterface
     */
    private function product()
    {
        return new Product();
    }

    /**
     * @return ArrayToEntityTransformerInterface
     */
    private function price()
    {
        return new Price;
    }

    /**
     * @return ArrayToEntityTransformerInterface
     */
    private function picture()
    {
        return new Picture();
    }
}