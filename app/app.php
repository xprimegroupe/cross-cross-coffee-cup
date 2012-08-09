<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Gedmo\Timestampable\TimestampableListener;

$app = new Application();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/providers.php';
require_once __DIR__ . '/config/routing.php';

$app->before(function() use ($app)
            {
            AnnotationRegistry::registerFile(__DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

            // globally used cache driver, in production use APC or memcached
            $cache = new Doctrine\Common\Cache\ArrayCache;
            // standard annotation reader
            $annotationReader = new Doctrine\Common\Annotations\AnnotationReader;
            $cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
                            $annotationReader, // use reader
                            $cache // and a cache driver
            );
            // create a driver chain for metadata reading
            $driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
            // load superclass metadata mapping only, into driver chain
            // also registers Gedmo annotations.NOTE: you can personalize it
            Gedmo\DoctrineExtensions::registerAbstractMappingIntoDriverChainORM(
                    $driverChain, // our metadata driver chain, to hook into
                    $cachedAnnotationReader // our cached annotation reader
            );

            //-- timestampable Listerner
            $timestampableListener = new TimestampableListener();
            $timestampableListener->setAnnotationReader($cachedAnnotationReader);
            $app['doctrine.dbal.event_manager']->addEventSubscriber(new TimestampableListener());
            });


//-- error
$app->error(function (\Exception $e, $code) use ($app)
            {
            if ($app['debug'])
            {
                return;
            }
            return $app['twig']->render('transversal/error.html.twig', array('code' => $code));
            });

return $app;