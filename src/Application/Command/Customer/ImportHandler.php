<?php

declare(strict_types=1);

namespace Discounter\Application\Command\Customer;

use Discounter\Domain\Customer\Customer;
use Discounter\Domain\Customer\Id;
use Discounter\Domain\Customer\Name;
use Discounter\Domain\Customer\Repository;
use Discounter\Domain\Customer\Revenue;
use Money\Money;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportHandler implements MessageHandlerInterface
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
     * @param Import $command
     */
    public function __invoke(Import $command): void
    {
        /**
         * This results in a float which is malpractice for currency in PHP.
         * Beter would be to provide the amount in cents by default.
         */
        $revenue = doubleval($command->getRevenue());
        $revenue *= 100;

        $customer = Customer::import(
            new Id($command->getId()),
            new Name($command->getName()),
            new \DateTimeImmutable($command->getSince()),
            Money::EUR($revenue)
        );

        $this->repository->save($customer);
    }
}
