<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 5:32 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry\PersonRepository;


use Example\PersonRegistry\Person;

class NativeArrayRepository implements Repository
{

    /**
     * @var Person[]
     */
    protected $persons = [];

    /**
     * @inheritdoc
     */
    public function all(): array
    {
        return $this->persons;
    }

}