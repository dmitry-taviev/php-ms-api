<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 4:59 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry;


use Example\PersonRegistry\PersonRepository\Repository;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller
{

    /**
     * @var Repository
     */
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function allPersons(): JsonResponse
    {
        return new JsonResponse(
            array_map(
                function(Person $person) {
                    return [
                        'id' => $person->id(),
                        'name' => $person->name()
                    ];
                },
                $this->repository->all()
            )
        );
    }

}