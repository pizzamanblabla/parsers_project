<?php

namespace ParserBundle\Operation\Update\Dto;

use ParserBundle\Entity\Category;
use ParserBundle\Interaction\Dto\Request\InternalRequestInterface;

class Request implements InternalRequestInterface
{
    /**
     * @var Category[]
     */
    private $categories = [];

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     * @return Request
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;
        return $this;
    }

}