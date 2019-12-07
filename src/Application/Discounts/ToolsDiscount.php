<?php

declare(strict_types=1);

namespace Discounter\Application\Discounts;

use Discounter\Application\Discounts\Order\Order;
use Discounter\Application\Discounts\Order\OrderLine;
use Discounter\Domain\Product\Id;
use Discounter\Domain\Product\Product;
use Discounter\Domain\Product\Repository;

class ToolsDiscount implements Discount
{
    private const CATEGORY_ID = 1;
    private const AMOUNT_NEEDED = 2;
    private const DISCOUNT_PERCENTAGE = 0.1;

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
        $relevantProducts = [];
        $quantity = 0;

        // Get relevant products
        foreach ($order->getOrderLines() as $orderLine) {
            $productId = $orderLine->getProductId();
            $product = $this->repository->find(new Id($productId));

            if (null === $product || $product->getCategoryId()->get() !== self::CATEGORY_ID) {
                continue;
            }

            $relevantProducts[$productId] = $product;
            $quantity += $orderLine->getQuantity();
        }

        // Do we enough products?
        if ($quantity < self::AMOUNT_NEEDED) {
            return null;
        }

        // Find cheapest product and discount 10% on it
        $cheapest = $this->getCheapestProduct($relevantProducts);
        $discount = $cheapest->getPrice()->multiply(self::DISCOUNT_PERCENTAGE);

        return new OrderLine(
            $cheapest->getId().'-TOOLSDISCOUNT',
            1,
            $discount->negative()
        );
    }

    /**
     * @param Product[] $products
     *
     * @return Product
     */
    private function getCheapestProduct(array $products): Product
    {
        /** @var Product|null $cheapest */
        $cheapest = null;
        foreach ($products as $product) {
            if ($cheapest === null || $product->getPrice()->lessThan($cheapest->getPrice())) {
                $cheapest = $product;
            }
        }
        return $cheapest;
    }

    /**
     * 0 - 50   Item discounts
     * 51 - 100 Full order discounts
     *
     * @return int
     */
    public function priority(): int
    {
        return 49;
    }
}
