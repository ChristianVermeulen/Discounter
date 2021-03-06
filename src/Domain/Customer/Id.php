<?php

declare(strict_types=1);

namespace Discounter\Domain\Customer;

use Assert\Assertion;

class Id
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        Assertion::greaterThan($id, 0, sprintf('Customer Id %d is not higher than 0.', $id));
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->id;
    }
}
