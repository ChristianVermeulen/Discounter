<?php

declare(strict_types=1);

namespace Discounter\Domain\Product;

interface Repository
{
    /**
     * @param Product $category
     */
    public function save(Product $category): void;

    /**
     * @param Id $productId
     *
     * @return Product|null
     */
    public function find(Id $productId):? Product;
}
