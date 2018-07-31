<?php

namespace RecBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $url = $client->getContainer()->get('router')->generate('rec_homepage');
        $crawler = $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful(), 'response status is 2xx');
        $this->assertGreaterThan(0,$crawler->filter('button#btRec')->count());
        $this->assertGreaterThan(0,$crawler->filter('a:contains("Остеопат.ру")')->count());

    }
}
