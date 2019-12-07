<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Repository\Customer;

use Discounter\Domain\Customer\Customer;
use Discounter\Domain\Customer\Id;
use Discounter\Domain\Customer\Repository;
use Doctrine\DBAL\Connection;

class DbalRepository implements Repository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Customer $customer): void
    {
        if (null === $this->find($customer->getId())) {
            $this->connection->insert('customers', $customer->toArray());

            return;
        }

        $this->connection->update(
            'customers',
            $customer->toArray(),
            [
                'id' => $customer->getId()->get()
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function find(Id $customerId): ?Customer
    {
        $statement = $this->connection->executeQuery('SELECT * FROM customers WHERE id = :id', ['id' => $customerId->get()]);
        $found = $statement->fetch(\PDO::FETCH_ASSOC);

        if (false === $found) {
            return null;
        }

        return Customer::fromArray($found);
    }
}
