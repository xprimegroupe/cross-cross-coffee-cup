<?php

namespace XP\C4\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class DefaultController
{

    public function homepageAction(Application $app)
    {
        $response = new Response();
        $response->setTtl(84600);
		$response->setCache(array(
            'last_modified' => new \DateTime(),
            'max_age' => 84600,
            's_maxage' => 84600,
            'private' => false,
            'public' => true,
        ));
        $response->setContent($app['twig']->render('default/homepage.html.twig', array(), $response));
		$response->prepare($app['request']);
		
		return $response;
    }

}
