<?php

namespace XP\C4\Controllers;

use Silex\Application;

class TransversalController
{

    public function homepageAction(Application $app)
    {
        return $app['twig']->render('transversal/homepage.html.twig');
    }

}
