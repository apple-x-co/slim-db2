<?php

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();
    $is_debug = $container->get('settings')['debug'];

    // validator
    $container['validator'] = function () {
        return new \Awurth\SlimValidation\Validator();
    };

    // csrf
    $container['csrf'] = function ($c) {
        //return new \Slim\Csrf\Guard;
        $guard = new \Slim\Csrf\Guard();
        $guard->setFailureCallable(function ($request, $response, $next) {
            $request = $request->withAttribute("csrf_status", false);
            return $next($request, $response);
        });
        return $guard;
    };

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // view
    $container['view'] = function ($c) {
        $settings = $c->get('settings');
        $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

        // Add extensions
        $view->addExtension(new \Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
        $view->addExtension(new \Twig_Extension_Debug());
        $view->addExtension(new \Awurth\SlimValidation\ValidatorExtension($c['validator']));
        $view->addExtension(new \App\Extension\TwigExtension\CsrfExtension($c->get('csrf')));
        return $view;
    };

    // DB
    $container[\Doctrine\ORM\EntityManager::class] = function ($container) {
        $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
            $container['settings']['doctrine']['metadata_dirs'],
            $container['settings']['doctrine']['dev_mode']
        );

        $config->setMetadataDriverImpl(
            new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
                new \Doctrine\Common\Annotations\AnnotationReader,
                $container['settings']['doctrine']['metadata_dirs']
            )
        );

        $config->setMetadataCacheImpl(
            new \Doctrine\Common\Cache\FilesystemCache(
                $container['settings']['doctrine']['cache_dir']
            )
        );

        return \Doctrine\ORM\EntityManager::create(
            $container['settings']['doctrine']['connection'],
            $config
        );
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    // debugbar
    $settings = $container->get('settings')['debugbar'];
    if ($is_debug) {
        $provider = new \Kitchenu\Debugbar\ServiceProvider($settings);
        $provider->register($app);

        $debugbar = $container['debugbar'];

        $logger = new \Monolog\Logger('slim-app');
        $debugbar->addCollector(new \DebugBar\Bridge\MonologCollector($logger));

        $loader = new \Twig_Loader_Filesystem('.');
        $env = new \DebugBar\Bridge\Twig\TraceableTwigEnvironment(new Twig_Environment($loader));
        $debugbar->addCollector(new \DebugBar\Bridge\Twig\TwigCollector($env));

        //$debugbar->addCollector(new \App\Extension\DebugbarExtension\EloquentCollector($container['db']));
    }

    // controllers
    $container[\App\Controller\UsersController::class] = function($c) {
        $view = $c->get('view');
        $db = $c->get('db');
        $router = $c->get('router');
        return new \App\Controller\UsersController($view, $db, $router);
    };
};
