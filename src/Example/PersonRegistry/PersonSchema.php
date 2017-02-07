<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 2/6/17
 * Time: 4:55 PM
 */

namespace Example\PersonRegistry;


use Neomerx\JsonApi\Schema\SchemaProvider;

class PersonSchema extends SchemaProvider
{

    public function getResourceType()
    {
        return 'persons';
    }

    /**
     * @param Person $person
     * @return string
     */
    public function getId($person)
    {
        return $person->id();
    }

    /**
     * @param Person $person
     * @return array
     */
    public function getAttributes($person)
    {
        return [
            'name' => $person->name()
        ];
    }

}