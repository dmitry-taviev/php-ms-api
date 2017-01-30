<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 5:03 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry\PersonRepository;


use Example\PersonRegistry\Person;

interface Repository
{

    /**
     * @return Person[]
     */
    public function all(): array;



}