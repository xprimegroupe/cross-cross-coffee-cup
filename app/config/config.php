<?php

$app['env'] = getenv('environment') ? getenv('environment') : 'dev';
$app['debug'] = getenv('debug') != null ? (bool) getenv('debug') : true;
if ($app['debug'])
{
    error_reporting(-1);
    ini_set('display_errors', '1');
}
$app['charset'] = 'UTF-8';
$app['locale'] = 'en';

//-- providers parameters 
//-- Doctrine
$app['doctrine.dbal.connection_options'] = array(
    'driver' => 'pdo_mysql',
    'dbname' => getenv('db_name') != null ? getenv('db_name') : '2cross1cup',
    'host' => getenv('db_host') != null ? getenv('db_host') : 'rio.local',
    'user' => getenv('db_user') != null ? getenv('db_user') : '2cross1cup',
    'password' => getenv('db_password') != null ? getenv('db_password') : 'pass4bdd',
);

$app['doctrine.orm'] = true;

$app['doctrine.orm.entities'] = array(
    array(
        'type' => 'annotation',
        'path' => array(
            __DIR__ . '/../../src/XP/C4/'
        ),
        'namespace' => 'XP\\C4\\Entity'
    )
);

//-- Twig
$app['twig.path'] = __DIR__ . '/../../src/XP/C4/Views';

//-- Monolog
$app['monolog.logfile'] = __DIR__ . '/../logs/' . $app['env'] . '.log';

//-- HttpCache
$app['http_cache.cache_dir'] = __DIR__ . '/../cache/';