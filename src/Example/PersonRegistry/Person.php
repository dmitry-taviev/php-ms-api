<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 5:05 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry;


class Person
{

    protected $id = '';

    protected $name = '';

    public function __construct(string $name)
    {
        $this->id = uniqid('example.persons.', true);
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

}