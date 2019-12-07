<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts;

use Discounter\Application\Discounts\Order\Order;

class ApplyDiscounts
{
    /**
     * @var Discount[]
     */
    private $discounts;

    /**
     * @param Discount ...$discounts
     */
    public function __construct(Discount...$discounts)
    {
        usort($discounts, function(Discount $a, Discount $b){
            return $a->priority() > $b->priority();
        });

        $this->discounts = $discounts;
    }

    /**
     * @param Order $order
     *
     * @return void
     */
    public function applyToOrder(Order $order): void
    {
        foreach ($this->discounts as $discount) {
            $orderLine = $discount->getForOrder($order);

            if ($orderLine) {
                $order->addOrderLine($orderLine);
            }
        }
    }
}
