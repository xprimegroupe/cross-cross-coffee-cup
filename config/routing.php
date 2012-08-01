<?php

$app->mount('/c4/', new XP\C4\Controllers\Providers\CrossCrossCoffeeCupControllerProvider());

$app->mount('/', new XP\C4\Controllers\Providers\TranversalControllerProvider());


//-- error
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;

$app->error(function (\Exception $e, $code) use ($app)
            {
            if ($app['debug'])
            {
                return;
            }
            return $app['twig']->render('transversal/error.html.twig', array('code' => $code));
            });