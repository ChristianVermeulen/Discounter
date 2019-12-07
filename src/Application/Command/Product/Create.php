<?php

declare(strict_types=1);

namespace Discounter\Application\Command\Product;

class Create
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $price;

    /**
     * @param string $id
     * @param string $description
     * @param int    $categoryId
     * @param string $price
     */
    public function __construct(
        string $id,
        string $description,
        int $categoryId,
        string $price
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->categoryId = $categoryId;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }
}
