<?php

declare(strict_types=1);

namespace Discounter\Domain\Customer;

use Assert\Assertion;

class Name
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        Assertion::notBlank($name, 'Name can not be empty.');
        Assertion::maxLength($name, 255, sprintf('Name %s can not exceed 255 characters.', $name));
        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
