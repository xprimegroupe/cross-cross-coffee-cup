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
    'db.options' => $app['db.options'],
));

//-- urlGenerator
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

//-- swiftmailer
$app->register(new Silex\Provider\SwiftmailerServiceProvider());

//-- HttpCache
$app->register(new Silex\Provider\HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/../cache/',
));