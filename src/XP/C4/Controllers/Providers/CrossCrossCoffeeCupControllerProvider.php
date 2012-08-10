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
        $controllers->get('/gallery/{page}', 'XP\C4\Controllers\CrossCrossCoffeeCupController::galleryAction')
                ->bind('c4_gallery')
                ->assert('page', '\d+')
                ->value('page', 1);
        
        $controllers->get('/cup/{id}', 'XP\C4\Controllers\CrossCrossCoffeeCupController::cupAction')
                ->bind('c4_cup')
                ->assert('id', '\d+');
        
        $controllers->post('/cup', 'XP\C4\Controllers\CrossCrossCoffeeCupController::saveAction')
                ->bind('c4_save');
        
        $controllers->post('/cup/share', 'XP\C4\Controllers\CrossCrossCoffeeCupController::shareAction')
                ->bind('c4_share');
        
        return $controllers;
    }

}