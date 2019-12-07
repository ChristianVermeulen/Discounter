<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Repository\Product;

use Discounter\Domain\Product\Product;
use Discounter\Domain\Product\Id;
use Discounter\Domain\Product\Repository;
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
    public function save(Product $product): void
    {
        if (null === $this->find($product->getId())) {
            $this->connection->insert('products', $product->toArray());

            return;
        }

        $this->connection->update(
            'products',
            $product->toArray(),
            [
                'id' => (string) $product->getId()
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function find(Id $productId): ?Product
    {
        $statement = $this->connection->executeQuery(
            'SELECT * FROM products WHERE id = :id',
            [
                'id' => (string) $productId
            ]
        );
        $found = $statement->fetch(\PDO::FETCH_ASSOC);

        if (false === $found) {
            return null;
        }

        return Product::fromArray($found);
    }
}
