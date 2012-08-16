<?php

namespace XP\C4\Tests;

use Silex\WebTestCase;

class CrossCrossCoffeCupControllerTest extends WebTestCase
{

    public function createApplication()
    {
        $app = require __DIR__ . '/../../../../../../../app/app.php';
        $app['debug'] = true;
        unset($app['exception_handler']);
        return $app;
    }
    

    public function testGalleryPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/c4/gallery');
		
    }

}