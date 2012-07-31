<?php
$app['env'] = getenv('environment')?getenv('environment'):'dev';
$app['debug'] = getenv('debug')?getenv('debug'):true;
if($app['debug']) {
    error_reporting(-1);
    ini_set('display_errors', '1');
}
$app['charset'] = 'UTF-8';
$app['locale'] = 'fr';