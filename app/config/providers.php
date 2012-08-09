<?php
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Knp\Silex\ServiceProvider\DoctrineServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

//-- Monolog
$app->register(new MonologServiceProvider());

//-- Twig
$app->register(new TwigServiceProvider(), array(
    'twig.path' => $app['twig.path'],
));

//-- Doctrine
$app->register(new DoctrineServiceProvider());

//-- urlGenerator
$app->register(new UrlGeneratorServiceProvider());

//-- swiftmailer
$app->register(new SwiftmailerServiceProvider());

//-- HttpCache
$app->register(new HttpCacheServiceProvider());

//-- Form
$app->register(new FormServiceProvider());

//-- Validator
$app->register(new ValidatorServiceProvider());
