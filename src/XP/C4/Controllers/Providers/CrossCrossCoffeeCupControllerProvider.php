<?php

namespace XP\C4\Controllers\Providers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class CrossCrossCoffeeCupControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];
        $controllers->get('/gallery', 'XP\C4\Controllers\CrossCrossCoffeeCupController::galleryAction')
                ->bind('c4_gallery');
        
        $controllers->get('/cup/{id}', 'XP\C4\Controllers\CrossCrossCoffeeCupController::cupAction')
                ->bind('c4_cup')
                ->assert('id', '\d+');
        
        $controllers->post('/cup', 'XP\C4\Controllers\CrossCrossCoffeeCupController::saveAction')
                ->bind('c4_save');
        
        return $controllers;
    }

}