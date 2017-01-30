<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/24/17
 * Time: 4:57 PM
 */

declare(strict_types=1);

namespace Example\PersonRegistry;


use AppServer\ApplicationComponent;
use Example\PersonRegistry\PersonRepository\NativeArrayRepository;
use Pimple\Container;
use Silex\Application;
use Silex\ControllerCollection;

class Component extends ApplicationComponent
{

    protected function registerServices(Container $container): void
    {
        $container['persons.repository'] = function() {
            return new NativeArrayRepository();
        };
        $container['persons.controller'] = function() use ($container) {
            return new Controller($container['persons.repository']);
        };
    }

    protected function registerRoutes(ControllerCollection $routing, Application $application): ControllerCollection
    {
        $routing->get('/', 'persons.controller:allPersons');
        return $routing;
    }

}