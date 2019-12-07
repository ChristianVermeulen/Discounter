<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts\Order;

use Money\Money;

class OrderLine
{
    /**
     * @var string
     **/
    private $productId;
    
    /**
     * @var int
     **/
    private $quantity;
    
    /**
     * @var Money
     **/
    private $unitPrice;

    /**
     * @var Money
     **/
    private $totalPrice;

    /**
     * @param string $productId
     * @param int    $quantity
     * @param Money  $unitPrice
     */
    public function __construct(string $productId, int $quantity, Money $unitPrice)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->totalPrice = $this->unitPrice->multiply($this->quantity);
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return Money
     */
    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    /**
     * @return Money
     */
    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }
}
