<?php

declare(strict_types=1);

namespace Discounter\Domain\Product;

use Assert\Assertion;

class Description
{
    /**
     * @var string
     */
    private $description;

    public function __construct(string $description)
    {
        Assertion::notBlank($description, 'Description can not be empty.');
        Assertion::maxLength($description, 255, sprintf('Description %s can not exceed 255 characters.', $description));
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->description;
    }
}
