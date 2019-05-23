<?php

use Slim\App;

return function (App $app) {
    // e.g: $app->add(new \Slim\Csrf\Guard);

    $container = $app->getContainer();

    // CSRF
    $app->add($container->get('csrf'));
};
