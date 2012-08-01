<?php

namespace XP\C4\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class CrossCrossCoffeeCupController
{

    public function galleryAction(Application $app, $start)
    {
        $total = $app['db']->fetchAssoc('SELECT count(*) as total FROM cup;');
        $total = $total['total'];

        // Start
        $next = $start + 6;
        $prev = ($start > 5) ? $start - 6 : 0;
        $total_page = ceil($total / 6);
        $current_page = $start / 6 + 1;

        $sql = 'SELECT * FROM cup ORDER BY created_at DESC LIMIT ' . ($start) . ' ,6;';

        $stmt = $app['db']->prepare($sql);
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

    public function cupAction(Application $app, $id)
    {
        $sql = 'SELECT * FROM cup WHERE id = :id';

        $stmt = $app['db']->prepare($sql);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $cup = $stmt->fetchAll();
        if (empty($cup))
        {
            $app->abort(404, "Cup $id does not exist.");
        }

        $cup = $cup[0];

        $sql = 'SELECT id FROM cup WHERE created_at < :created_at AND id != :id ORDER BY created_at DESC LIMIT 1';
        $stmt = $app['db']->prepare($sql);
        $stmt->bindValue('created_at', $cup['created_at']);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $prev = $stmt->fetchAll();

        $sql = 'SELECT id FROM cup WHERE created_at > :created_at AND id != :id ORDER BY created_at ASC LIMIT 1;';
        $stmt = $app['db']->prepare($sql);
        $stmt->bindValue('created_at', $cup['created_at']);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $next = $stmt->fetchAll();

        $response = new Response();

        $response->setTtl(84600);
        $response->setCache(array(
            'last_modified' => new \DateTime(),
            'max_age' => 84600,
            's_maxage' => 84600,
            'private' => false,
            'public' => true,
        ));

        return $app['twig']->render('cross-cross-coffee-cup/cup.html.twig', array(
                    'cup' => $cup,
                    'prev' => !empty($prev) ? $prev[0] : false,
                    'next' => !empty($next) ? $next[0] : false,
                    'from_email' => $app['request']->get('from_email')
                        ), $response
        );
    }

    public function saveAction(Application $app)
    {
        if (!$app['request']->get('svg'))
        {
            $app->abort(404, 'No svg paramater given');
        }

        $stmt = $app['db']->prepare("INSERT INTO cup (name, twitter, img_big, created_at) VALUES (:name, :twitter, :img_big, NOW());");
        $stmt->bindValue('name', $app['request']->get('name'), \PDO::PARAM_STR);
        $stmt->bindValue('twitter', $app['request']->get('twitter'), \PDO::PARAM_STR);
        $stmt->bindValue('img_big', $app['request']->get('svg'), \PDO::PARAM_STR);

        $stmt->execute();

        return $app['db']->lastInsertId();
    }

    public function shareAction(Application $app)
    {
        $share = $app['request']->get('share');
        
        $message = \Swift_Message::newInstance()
                ->setSubject($share['name']." vous a envoyé une CROSS:CROSS COFFEE CUP")
                ->setFrom(array('contact@crosscrosscoffeecup.com'))
                ->setTo(array($share['mail'] => $share['name']))
                ->setBody($app['twig']->render('transversal/_share.email.html.twig', array('id' => $share['id'])),'text/html');
        $send = $app['mailer']->send($message);

        return $app->redirect($app['url_generator']->generate('c4_cup', array(
            'id' => $share['id'],
            'from_email' => $send
            )));
    }

}
