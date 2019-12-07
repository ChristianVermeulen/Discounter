<?php

declare(strict_types=1);

namespace Discounter\Domain\Category;

class Category
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
     * Protect construct
     */
    private function __construct(){}

    /**
     * @param Id   $id
     * @param Name $name
     *
     * @return static
     */
    public static function create(Id $id, Name $name): self
    {
        $self = new self();
        $self->id = $id;
        $self->name = $name;

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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id->get(),
            'name' => (string) $this->name
        ];
    }

    /**
     * @param array $category
     *
     * @return static
     */
    public static function fromArray(array $category): self
    {
        $self = new self();
        $self->id = new Id($category['id']);
        $self->name = new Name($category['name']);

        return $self;
    }
}
