<?php

declare(strict_types=1);

namespace Discounter\Infrastructure\Repository\Category;

use Discounter\Domain\Category\Category;
use Discounter\Domain\Category\Id;
use Discounter\Domain\Category\Repository;
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
    public function save(Category $category): void
    {
        if (null === $this->find($category->getId())) {
            $this->connection->insert('categories', $category->toArray());

            return;
        }

        $this->connection->update(
            'categories',
            $category->toArray(),
            [
                'id' => $category->getId()->get()
            ]
        );
    }

    /**
     * {@inheritDoc}
     */
    public function find(Id $CategoryId): ?Category
    {
        $statement = $this->connection->executeQuery('SELECT * FROM categories WHERE id = :id', ['id' => $CategoryId->get()]);
        $found = $statement->fetch(\PDO::FETCH_ASSOC);

        if (false === $found) {
            return null;
        }

        return Category::fromArray($found);
    }
}
