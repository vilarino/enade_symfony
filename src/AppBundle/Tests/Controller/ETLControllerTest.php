<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ETLControllerTest extends WebTestCase
{
    public function testProcesso()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/processo');
    }

}
