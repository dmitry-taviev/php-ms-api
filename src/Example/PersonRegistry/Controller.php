<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 4:59 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry;


use AppServer\Encoder\EncoderFactory;
use Example\PersonRegistry\PersonRepository\Repository;
use Symfony\Component\HttpFoundation\Response;

class Controller
{

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;

    public function __construct(Repository $repository, EncoderFactory $encoderFactory)
    {
        $this->repository = $repository;
        $this->encoderFactory = $encoderFactory;
    }

    public function allPersons(): Response
    {
        return $this->encoderFactory
            ->encoder([
                Person::class => PersonSchema::class
            ])
            ->response($this->repository->all());
    }

}