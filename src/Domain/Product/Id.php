<?php

declare(strict_types=1);

namespace Discounter\Domain\Product;

use Assert\Assertion;

class Id
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        Assertion::notBlank($id, 'ID can not be empty.');
        Assertion::maxLength($id, 255, sprintf('ID %s can not exceed 255 characters.', $id));
        $this->id = $id;
    }

    public function __toString()
    {
        return $this->id;
    }
}
