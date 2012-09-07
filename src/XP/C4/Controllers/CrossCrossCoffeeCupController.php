<?php

namespace XP\C4\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use XP\C4\Entity\Cup;

class CrossCrossCoffeeCupController
{
    /**
     * galleryAction()
     * @param \Silex\Application $app
     * @param int $start
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleryAction(Application $app, $page)
    {   
        $max_per_page = $app['cup.list_max_per_page'];

        $cups = $app['doctrine.orm.em']->getRepository('XP\C4\Entity\Cup')->getPager($page, $max_per_page);
        
        $total = count($cups);

        return $app['twig']->render('cross-cross-coffee-cup/gallery.html.twig', array(
                    'cups' => $cups,
                    'page' => $page,
                    'last_page' => ceil($total / $max_per_page),
                    'prev' => ($page - 1) > 1 ? $page - 1 : 1,
                    'next' =>  $page + 1
                        )
        );
    }
    
    /**
     * cupAction()
     * @param \Silex\Application $app
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cupAction(Application $app, $id)
    {
        
        $cup = $app['doctrine.orm.em']->getRepository('XP\C4\Entity\Cup')->findOneBy(array('id' => $id));
        if (!$cup)
        {
            $app->abort(404, "Cup $id does not exist.");
        }
        //-- prev
        $prev = $app['doctrine.orm.em']->getRepository('XP\C4\Entity\Cup')->getPreviousCups($cup);
        
        //-- next
        $next = $app['doctrine.orm.em']->getRepository('XP\C4\Entity\Cup')->getNextCups($cup);

        return $app['twig']->render('cross-cross-coffee-cup/cup.html.twig', array(
                    'cup' => $cup,
                    'prev' => !empty($prev) ? $prev[0] : false,
                    'next' => !empty($next) ? $next[0] : false,
                    'from_email' => $app['request']->get('from_email')
                        )
        );
    }
    
    /**
     * saveAction()
     * @param \Silex\Application $app
     * @return int
     */
    public function saveAction(Application $app)
    {
        if (!$app['request']->get('svg'))
        {
            $app->abort(404, 'No svg parameter given');
        }
        
        $cup = new Cup();
        $cup->setName($app['request']->get('name'))
                ->setTwitter( $app['request']->get('twitter'))
                ->setImgBig( $app['request']->get('svg'));
        
        $app['doctrine.orm.em']->persist($cup);
        $app['doctrine.orm.em']->flush();

        return $cup->getId();
    }
    
    /**
     * shareAction()
     * @param \Silex\Application $app
     * @return type
     */
    public function shareAction(Application $app)
    {
        $share = $app['request']->get('share');
		$send = false;
		
        if (filter_var($share['mail'], FILTER_VALIDATE_EMAIL) !== false) 
		{
			$message = \Swift_Message::newInstance()
					->setSubject($share['name']." vous a envoyé une CROSS:CROSS COFFEE CUP")
					->setFrom(array('contact@crosscrosscoffeecup.com'))
					->setTo(array($share['mail'] => $share['name']))
					->setBody($app['twig']->render('default/_share.email.html.twig', array('id' => $share['id'])),'text/html');
			$send = $app['mailer']->send($message);
		}

        return $app->redirect($app['url_generator']->generate('c4_cup', array(
            'id' => $share['id'],
            'from_email' => $send
            )));
    }

}
