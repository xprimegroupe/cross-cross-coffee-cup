<?php

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/config/providers.php';
require_once __DIR__.'/config/routing.php';

return $app;
