<?php

namespace XP\C4\Controllers\Providers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;

class TranversalControllerProvider implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        // creates a new controller based on the default route
        $controllers = $app['controllers_factory'];
        $controllers->get('/', 'XP\C4\Controllers\TransversalController::homepageAction')->bind('homepage');
        
        return $controllers;
    }

}