<?php

declare(strict_types=1);

namespace Discounter\Application\Command\Product;

use Discounter\Domain\Category\Id as CategoryId;
use Discounter\Domain\Product\Price;
use Discounter\Domain\Product\Product;
use Discounter\Domain\Product\Id;
use Discounter\Domain\Product\Description;
use Discounter\Domain\Product\Repository;
use Money\Money;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateHandler implements MessageHandlerInterface
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Create $command
     */
    public function __invoke(Create $command): void
    {
        /**
         * This results in a float which is malpractice for currency in PHP.
         * Beter would be to provide the amount in cents by default.
         */
        $price = doubleval($command->getPrice());
        $price *= 100;

        $product = Product::create(
            new Id($command->getId()),
            new Description($command->getDescription()),
            new CategoryId($command->getCategoryId()),
            Money::EUR($price)
        );

        $this->repository->save($product);
    }
}
