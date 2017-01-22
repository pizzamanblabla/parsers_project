<?php

namespace ParserBundle\Operation\Parse\Dto;

use ParserBundle\Interaction\Dto\Response\InternalResponseInterface;
use ParserBundle\Interaction\Dto\Response\Successful;

class SuccessfulResponse implements InternalResponseInterface
{
    use Successful;

    /**
     * @var array
     */
    private $data;

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return SuccessfulResponse
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}