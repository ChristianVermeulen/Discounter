<?php

declare(strict_types=1);

namespace Discounter\Domain\Product;

use Discounter\Domain\Category\Id as CategoryId;
use Money\Money;

class Product
{
    /**
     * @var Id
     **/
    private $id;

    /**
     * @var Description
     **/
    private $description;

    /**
     * @var CategoryId
     **/
    private $categoryId;

    /**
     * @var Money
     **/
    private $price;

    /**
     * Protect construct
     */
    private function __construct(){}

    /**
     * @param Id          $id
     * @param Description $description
     * @param CategoryId  $categoryId
     * @param Money       $price
     *
     * @return static
     */
    public static function create(
        Id $id,
        Description $description,
        CategoryId $categoryId,
        Money $price
    ): self {
        $self              = new self();
        $self->id          = $id;
        $self->description = $description;
        $self->categoryId  = $categoryId;
        $self->price       = $price;

        return $self;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return CategoryId
     */
    public function getCategoryId(): CategoryId
    {
        return $this->categoryId;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => (string) $this->id,
            'description' => (string) $this->description,
            'category_id' => $this->categoryId->get(),
            'price' => $this->price->getAmount()
        ];
    }

    /**
     * @param array $product
     *
     * @return static
     */
    public static function fromArray(array $product): self
    {
        $self              = new self();
        $self->id          = new Id($product['id']);
        $self->description = new Description($product['description']);
        $self->categoryId  = new CategoryId((int) $product['category_id']);
        $self->price       = Money::EUR($product['price']);
        return $self;
    }
}
