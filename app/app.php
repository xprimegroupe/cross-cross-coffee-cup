<?php
date_default_timezone_set('europe/paris');
$loader = require __DIR__ . '/../vendor/autoload.php';

use Silex\Application;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Gedmo\Timestampable\TimestampableListener;
use Symfony\Component\HttpFoundation\Request;

$app = new Application();

//-- config
require __DIR__ . '/config/config.php';
require __DIR__ . '/config/providers.php';
require __DIR__ . '/config/routing.php';
            
//-- init application
$app->before(function() use ($app, $loader)
            {
            AnnotationRegistry::registerLoader(function($class) use ($loader)
                        {
                        $loader->loadClass($class);
                        return class_exists($class, false);
                        });
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
            return $app['twig']->render('default/error.html.twig', array('code' => $code));
            });

if('preprod' == $app['env']) {
    //-- hack for PP(xpfabric)
    Request::trustProxyData();
}

return $app;
