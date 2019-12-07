<?php

declare(strict_types=1);

namespace Discounter\Domain\Customer;

interface Repository
{
    /**
     * @param Customer $customer
     */
    public function save(Customer $customer): void;

    /**
     * @param Id $customerId
     *
     * @return Customer|null
     */
    public function find(Id $customerId):? Customer;
}
