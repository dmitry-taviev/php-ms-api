<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 1/18/17
 * Time: 4:45 PM
 */

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

// APPLICATION
$app = new \Silex\Application();
\Symfony\Component\Debug\ErrorHandler::register();
$app->before(function(\Symfony\Component\HttpFoundation\Request $request) {
    if ($request->headers->get('Content-Type') === 'application/json') {
        $decoded = json_decode($request->getContent(), true);
        $request->request->replace(is_array($decoded) ? $decoded : []);
    }
});

$storage = ['persons' => []];

//$app['persons'] = [
//    ['id' => 0, 'name' => 'Dmitry']
//];

$app->get('/persons', function() use ($app, &$storage) {
    return $app->json($storage['persons']);
});
$app->get('/persons/{id}', function(int $id) use ($app, &$storage) {
    return $app->json($storage['persons'][$id - 1]);
});
$app->post('/persons', function(\Symfony\Component\HttpFoundation\Request $request) use ($app, &$storage) {
    $newId = count($storage['persons']);
    $storage['persons'][$newId] = [
        'id' => $newId + 1,
        'name' => $request->request->getAlpha('name')
    ];
    return $app->json($storage['persons'][$newId], 201);
});

// SERVER

$loop = \React\EventLoop\Factory::create();
$socket = new \React\Socket\Server($loop);
$server = new \React\Http\Server($socket);
$server->on('request', function(\React\Http\Request $request, \React\Http\Response $response) use ($app) {
    $contentLength = (int) $request->getHeaders()['Content-Length'];
    $dataReceived = '';
    $totalDataLength = 0;
    $request->on('data', function(string $data) use (&$dataReceived, &$totalDataLength, $contentLength, $request, $response, $app) {
        $dataReceived .= $data;
        $totalDataLength += strlen($data);
        if ($totalDataLength >= $contentLength) {
            parse_str($dataReceived, $postParameters);
            $method = $request->getMethod();
            $input = \Symfony\Component\HttpFoundation\Request::create(
                $request->getPath(),
                $method,
                ($method === 'GET' ? $request->getQuery() : $postParameters),
                [],
                [],
                [],
                $dataReceived
            );
            $input->headers->replace($request->getHeaders());
            $output = $app->handle($input);
            $app->terminate($input, $output);
            $response->writeHead(
                $output->getStatusCode(),
                array_map(
                    function(array $headerValues) {
                        return $headerValues[0];
                    },
                    $output->headers->all()
                )
            );
            $response->end($output->getContent());
            $request->close();
        }
    });

});

$socket->listen(1337, '0.0.0.0');

echo 'Listening on ' . $socket->getPort() . PHP_EOL;

$loop->run();
