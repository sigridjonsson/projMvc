<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ControllerIndexTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h2', 'Välkommen!');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testTextIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        // $this->assertResponseIsSuccessful();
        // $this->assertSelectorTextContains('h2', 'Välkommen!');
        $this->assertSelectorTextContains('h2', 'Välkommen!');
    }
}
