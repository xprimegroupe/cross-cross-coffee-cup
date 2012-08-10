<?php

namespace XP\C4\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{

    public function homepageAction(Application $app)
    {
        return $app['twig']->render('default/homepage.html.twig', array());
    }

}
