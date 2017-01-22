<?php

namespace ParserBundle\Internal\Enum;

class ResponseType extends Enumeration
{
    const SUCCESSFUL = 1;

    const ERRONEOUS = 2;

    const EXCEPTIONAL = 3;

    /**
     * @return ResponseType
     */
    public static function successful()
    {
        return new self(static::SUCCESSFUL);
    }

    /**
     * @return ResponseType
     */
    public static function erroneous()
    {
        return new self(static::ERRONEOUS);
    }

    /**
     * @return ResponseType
     */
    public static function exceptional()
    {
        return new self(static::EXCEPTIONAL);
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->value == static::SUCCESSFUL;
    }

    /**
     * @return bool
     */
    public function isErroneous()
    {
        return $this->value == static::ERRONEOUS;
    }

    /**
     * @return bool
     */
    public function isExceptional()
    {
        return $this->value == static::EXCEPTIONAL;
    }
}
