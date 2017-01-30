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

//$storage = ['persons' => []];
//
//$app->get('/persons', function() use ($app, &$storage) {
//    return $app->json($storage['persons']);
//});
//$app->get('/persons/{id}', function(int $id) use ($app, &$storage) {
//    return $app->json($storage['persons'][$id - 1]);
//});
//$app->post('/persons', function(\Symfony\Component\HttpFoundation\Request $request) use ($app, &$storage) {
//    $newId = count($storage['persons']);
//    $storage['persons'][$newId] = [
//        'id' => $newId + 1,
//        'name' => $request->request->getAlpha('name')
//    ];
//    return $app->json($storage['persons'][$newId], 201);
//});

// SERVER
$server = new \AppServer\BasicServer(true);
$server->serve($app, 1337);