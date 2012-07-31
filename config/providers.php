<?php

//-- Monolog
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../logs/' . $app['env'] . '.log',
));

//-- Twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/XP/C4/Views',
));


//-- Doctrine
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
        'dbname' => '2cross1cup',
        'host' => 'rio.local',
        'user' => '2cross1cup',
        'password' => 'pass4bdd',
    ),
));

//-- urlGenerator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//-- swiftmailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());