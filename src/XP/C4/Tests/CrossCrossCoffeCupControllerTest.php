<?php

$loader = require_once __DIR__ . '/../../../../vendor/autoload.php';

namespace XP\C4\Tests;

use Silex\WebTestCase;

class CrossCrossCoffeCupControllerTest extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../app/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);
        return $app;
    }
    

    public function testGalleryPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/c4/gallery');
        $profile = $client->getProfile();

        // ... write some assertions about the Response
        // Check that the profiler is enabled
        if ($profile)
        {
            // check the number of requests
            $this->assertLessThan(10, $profile->getCollector('db')->getQueryCount());

            // check the time spent in the framework
            $this->assertLessThan(0.5, $profile->getCollector('timer')->getTime());
        }
    }

}