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
    public function galleryAction(Application $app, $start)
    {
        $total = $app['doctrine.dbal.connection']->fetchAssoc('SELECT count(*) as total FROM cup;');
        $total = $total['total'];

        // Start
        $next = $start + 6;
        $prev = ($start > 5) ? $start - 6 : 0;
        $total_page = ceil($total / 6);
        $current_page = $start / 6 + 1;

        $sql = 'SELECT * FROM cup ORDER BY created_at DESC LIMIT ' . ($start) . ' ,6;';

        $stmt = $app['doctrine.dbal.connection']->prepare($sql);
        $stmt->execute();
        $cups = $stmt->fetchAll();

        return $app['twig']->render('cross-cross-coffee-cup/gallery.html.twig', array(
                    'cups' => $cups,
                    'start' => $start,
                    'total' => $total,
                    'total_page' => $total_page,
                    'current_page' => $current_page,
                    'prev' => $prev,
                    'next' => $next
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

        $response = new Response();

        $response->setTtl(84600);
        $response->setCache(array(
            'last_modified' => new \DateTime(),
            'max_age' => 84600,
            's_maxage' => 84600,
            'private' => false,
            'public' => true,
        ));

        $response->setContent($app['twig']->render('cross-cross-coffee-cup/cup.html.twig', array(
                    'cup' => $cup,
                    'prev' => !empty($prev) ? $prev[0] : false,
                    'next' => !empty($next) ? $next[0] : false,
                    'from_email' => $app['request']->get('from_email')
                        )
                ));

        $response->prepare($app['request']);

        return $response;
    }

    /**
     * saveAction()
     * @param \Silex\Application $app
     * @return json
     */
    public function saveAction(Application $app)
    {
        if (!$app['request']->get('svg'))
        {
            $app->abort(404, 'No svg paramater given');
        }

        $cup = new Cup();
        $cup->setName($app['request']->get('name'))
                ->setTwitter($app['request']->get('twitter'))
                ->setImgBig($app['request']->get('svg'));

        $app['doctrine.orm.em']->persist($cup);
        $app['doctrine.orm.em']->flush();

        return $app->json(array(
                    'data' => array(
                        'id' => $cup->getId()
                    )
                        )
        );
    }

    /**
     * shareAction()
     * @param \Silex\Application $app
     * @return type
     */
    public function shareAction(Application $app)
    {
        $share = $app['request']->get('share');

        $message = \Swift_Message::newInstance()
                ->setSubject($share['name'] . " vous a envoyé une CROSS:CROSS COFFEE CUP")
                ->setFrom(array('contact@crosscrosscoffeecup.com'))
                ->setTo(array($share['mail'] => $share['name']))
                ->setBody($app['twig']->render('default/_share.email.html.twig', array('id' => $share['id'])), 'text/html');
        $send = $app['mailer']->send($message);

        return $app->redirect($app['url_generator']->generate('c4_cup', array(
                            'id' => $share['id'],
                            'from_email' => $send
                        )));
    }

}
