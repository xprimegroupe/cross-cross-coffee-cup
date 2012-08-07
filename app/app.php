<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;

$app = new Application();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/providers.php';
require_once __DIR__ . '/config/routing.php';

//-- error

$app->error(function (\Exception $e, $code) use ($app)
            {
            if ($app['debug'])
            {
                return;
            }
            return $app['twig']->render('transversal/error.html.twig', array('code' => $code));
            });

return $app;