<?php

declare(strict_types=1);

namespace Discounter\Application\Command\Customer;

class Import
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $since;

    /**
     * @var string
     */
    private $revenue;

    public function __construct(
        int $id,
        string $name,
        string $since,
        string $revenue
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->since = $since;
        $this->revenue = $revenue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSince(): string
    {
        return $this->since;
    }

    /**
     * @return string
     */
    public function getRevenue(): string
    {
        return $this->revenue;
    }
}
