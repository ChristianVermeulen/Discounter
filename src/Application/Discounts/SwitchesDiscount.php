<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts;

use Discounter\Application\Discounts\Order\Order;
use Discounter\Application\Discounts\Order\OrderLine;
use Discounter\Domain\Product\Id;
use Discounter\Domain\Product\Repository;
use Money\Money;

class SwitchesDiscount implements Discount
{
    private const CATEGORY_ID = 2;
    private const AMOUNT_NEEDED = 5;
    private const AMOUNT_AWARDED = 1;

    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function getForOrder(Order $order):? OrderLine
    {
        foreach ($order->getOrderLines() as $orderLine) {
            if ($orderLine->getQuantity() !== self::AMOUNT_NEEDED) {
                continue;
            }

            $productId = $orderLine->getProductId();
            $product = $this->repository->find(new Id($productId));

            if (null === $product || $product->getCategoryId()->get() !== self::CATEGORY_ID) {
                continue;
            }

            return new OrderLine(
                $productId.'-BUY5GET6',
                self::AMOUNT_AWARDED,
                Money::EUR(0)
            );
        }

        return null;
    }

    /**
     * 0 - 50   Item discounts
     * 51 - 100 Full order discounts
     *
     * @return int
     */
    public function priority(): int
    {
        return 50;
    }
}
