<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts\Order;

use Discounter\Domain\Customer\Id;
use Money\Money;

class Order
{
    /**
     * @var Id
     **/
    private $customerId;

    /**
     * @var OrderLine[]
     **/
    private $orderLines;

    /**
     * @var Money
     **/
    private $totalPrice;

    private function __construct(){}

    /**
     * @param array $order
     *
     * @return static
     */
    public static function fromArray(array $order): self
    {
        $self             = new self();
        $self->customerId = new Id((int) $order['customer-id']);
        $self->totalPrice = Money::EUR(0);

        foreach ($order['items'] as $orderLine) {
            $unitPrice = doubleval($orderLine['unit-price']);
            $unitPrice *= 100;
            $unitPrice = Money::EUR($unitPrice);

            $self->addOrderLine(new OrderLine($orderLine['product-id'], (int) $orderLine['quantity'], $unitPrice));
        }

        return $self;
    }

    /**
     * @return Id
     */
    public function getCustomerId(): Id
    {
        return $this->customerId;
    }

    /**
     * @return OrderLine[]
     */
    public function getOrderLines(): array
    {
        return $this->orderLines;
    }

    public function addOrderLine(OrderLine $orderLine): void
    {
        $this->orderLines[] = $orderLine;
        $this->recalculateTotalPrice();
    }

    /**
     * @return Money
     */
    public function getTotalPrice(): Money
    {
        return $this->totalPrice;
    }

    private function recalculateTotalPrice(): void
    {
        $totalPrice = Money::EUR(0);
        foreach($this->orderLines as $orderLine) {
            $totalPrice = $totalPrice->add($orderLine->getTotalPrice());
        }
        $this->totalPrice = $totalPrice;
    }
}
