<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts;

use Discounter\Application\Discounts\Order\Order;
use Discounter\Application\Discounts\Order\OrderLine;

interface Discount
{
    /**
     * @param Order $order
     *
     * @return OrderLine|null
     */
    public function getForOrder(Order $order):? OrderLine;

    /**
     * 0 - 50   Full order discounts
     * 51 - 100 Item discounts
     *
     * @return int
     */
    public function priority(): int;
}
