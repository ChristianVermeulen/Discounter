<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts;

use Discounter\Application\Discounts\Order\Order;
use Discounter\Application\Discounts\Order\OrderLine;
use Discounter\Domain\Customer\Repository;
use Money\Money;

class LoyaltyDiscount implements Discount
{
    private const LOYALTY_THRESHOLD = 100000; // € 1000
    private const LOYALTY_DISCOUNT_PERCENTAGE = 0.1;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     */
    public function getForOrder(Order $order):? OrderLine
    {
        $customer = $this->repository->find($order->getCustomerId());

        if (null === $customer) {
            return null;
        }

        $revenue = $customer->getRevenue();

        if ($revenue->lessThan(Money::EUR(self::LOYALTY_THRESHOLD))) {
            return null;
        }

        $discount = $order->getTotalPrice()->multiply(self::LOYALTY_DISCOUNT_PERCENTAGE);

        $orderLine = new OrderLine(
            'LOYALTY',
            1,
            $discount->negative()
        );

        return $orderLine;
    }

    /**
     * 0 - 50   Item discounts
     * 51 - 100 Full order discounts
     *
     * @return int
     */
    public function priority(): int
    {
        return 100;
    }
}
