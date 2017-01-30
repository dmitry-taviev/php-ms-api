<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/18/17
 * Time: 4:45 PM
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
\Symfony\Component\Debug\ErrorHandler::register();
// APPLICATION
$app = new \AppServer\Application();
$app->mount('/persons', new \Example\PersonRegistry\Component());

// SERVER
$debugging = true;
$server = new \AppServer\BasicServer($debugging);
$server->serve($app, 1337);