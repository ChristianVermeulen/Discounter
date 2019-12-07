<?php

declare(strict_types=1);

namespace Discounter\Application\Command\Category;

use Discounter\Domain\Category\Category;
use Discounter\Domain\Category\Id;
use Discounter\Domain\Category\Name;
use Discounter\Domain\Category\Repository;
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
        $category = Category::create(
            new Id($command->getId()),
            new Name($command->getName())
        );

        $this->repository->save($category);
    }
}
