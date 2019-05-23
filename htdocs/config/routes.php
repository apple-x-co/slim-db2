<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

//    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
//        // Sample log message
//        $container->get('logger')->info("Slim-Skeleton '/' route");
//
//        // Render index view
//        return $container->get('renderer')->render($response, 'index.phtml', $args);
//    });

//    $app->any('/contact', function (Request $request, Response $response, array $args) use ($container) {
//        // Sample log message
//        $container->get('logger')->info("Slim-Skeleton '/' route");
//
//        // Render index view
//        return $container->get('renderer')->render($response, 'index.phtml', $args);
//    });

    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        $this->view->render($response, 'index.phtml');
    });

    $app->group('/users', function(App $app){
        $app->get('/', \App\Controller\UsersController::class . ':index')
            ->setName('users.index');

        $app->get('/create', \App\Controller\UsersController::class . ':create')
            ->setName('users.create');

        $app->get('/{id:[0-9]+}', \App\Controller\UsersController::class . ':detail')
            ->setName('users.detail');
    });

};
