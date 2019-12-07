<?php

declare(strict_types=1);

namespace Discounter\Domain\Category;

interface Repository
{
    /**
     * @param Category $category
     */
    public function save(Category $category): void;

    /**
     * @param Id $CategoryId
     *
     * @return Category|null
     */
    public function find(Id $CategoryId):? Category;
}
