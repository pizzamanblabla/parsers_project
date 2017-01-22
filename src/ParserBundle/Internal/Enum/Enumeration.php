<?php

namespace ParserBundle\Internal\Enum;

use ReflectionClass;

abstract class Enumeration
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string[]
     */
    protected $names = [];

    /**
     * @param mixed $value
     */
    final public function __construct($value)
    {
        if (!static::contains($value)) {
            throw new \Exception(strtr("'{value}' is not a valid value", ['{value}' => $value]));
        }

        $this->value = $value;
    }

    /**
     * @param mixed $value
     * @return $this
     */
    final public static function create($value)
    {
        return new static($value);
    }

    /**
     * @return mixed[]
     */
    final public static function getValuesList()
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * @return string[]
     */
    final public static function getNamesList()
    {
        $values = static::getValuesList();

        return (new static(reset($values)))->names;
    }

    /**
     * @param mixed $value
     * @return boolean
     */
    final public static function contains($value)
    {
        return in_array($value, static::getValuesList());
    }

    /**
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    final public function getName()
    {
        if (!isset($this->names[$this->getValue()])) {
            throw new \Exception(strtr("Name for value '{value}' does not exists", ['{value}' => $this->getValue()]));
        }

        return $this->names[$this->getValue()];
    }

    /**
     * @param Enumeration|string $value
     * @return boolean
     */
    public function eq($value)
    {
        if (!is_object($value)) {
            return ($this->value == $value);
        }

        if (!is_a($value, get_class($this))) {
            throw new \Exception(strtr("'{class}' is not a valid class", ['{class}' => get_class($this)]));
        }
        /* @var Enumeration $value */

        return ($this->getValue() == $value->getValue());
    }
}
