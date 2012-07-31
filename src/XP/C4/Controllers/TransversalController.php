<?php

namespace XP\C4\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class TransversalController
{

    public function homepageAction(Application $app)
    {
        $response = new Response();
        $response->setTtl(84600);
        return $app['twig']->render('transversal/homepage.html.twig', array(), $response);
    }

}
