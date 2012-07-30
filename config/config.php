<?php
$app['env'] = getenv('environment')?getenv('environment'):'dev';
$app['debug'] = getenv('debug')?getenv('debug'):true;
$app['charset'] = 'UTF-8';
$app['locale'] = 'fr';