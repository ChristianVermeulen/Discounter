<?php

declare(strict_types=1);

namespace Discounter\Domain\Customer;

use Money\Money;

class Customer
{
    /**
     * @var Id
     **/
    private $id;

    /**
     * @var Name
     **/
    private $name;

    /**
     * @var \DateTimeImmutable
     **/
    private $since;

    /**
     * @var Money
     **/
    private $revenue;

    /**
     * Protect construct
     */
    private function __construct(){}

    /**
     * @param Id                 $id
     * @param Name               $name
     * @param \DateTimeImmutable $since
     * @param Money              $revenue
     *
     * @return self
     */
    public static function import(
        Id $id,
        Name $name,
        \DateTimeImmutable $since,
        Money $revenue
    ): self{
        $self = new self();
        $self->id = $id;
        $self->name = $name;
        $self->since = $since;
        $self->revenue = $revenue;

        return $self;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Money
     */
    public function getRevenue(): Money
    {
        return $this->revenue;
    }

    public function checkout(Money $total): void
    {
        $this->revenue->add($total);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->get(),
            'name' => (string) $this->name,
            'since' => $this->since->format(DATE_ATOM),
            'revenue' => $this->revenue->getAmount()
        ];
    }

    /**
     * @param array $customer
     *
     * @return self
     */
    public static function fromArray(array $customer): self
    {
        $self = new self();
        $self->id = new Id((int) $customer['id']);
        $self->name = new Name($customer['name']);
        $self->since = new \DateTimeImmutable($customer['since']);
        $self->revenue = Money::EUR($customer['revenue']);

        return $self;
    }
}
