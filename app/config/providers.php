<?php
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

//-- Monolog
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__ . '/../logs/' . $app['env'] . '.log',
));

//-- Twig
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../../src/XP/C4/Views',
));


//-- Doctrine
$app->register(new DoctrineServiceProvider(), array(
    'db.options' => $app['db.options'],
));

//-- urlGenerator
$app->register(new UrlGeneratorServiceProvider());

//-- swiftmailer
$app->register(new SwiftmailerServiceProvider());

//-- HttpCache
$app->register(new HttpCacheServiceProvider(), array(
    'http_cache.cache_dir' => __DIR__.'/../cache/',
));

//-- Form
$app->register(new FormServiceProvider());

//-- Validator
$app->register(new ValidatorServiceProvider());