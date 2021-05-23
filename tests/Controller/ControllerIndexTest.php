<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// use Symfony\Component\HttpFoundation\Response;

class ControllerIndexTest extends WebTestCase
{
    // public function testIndex()
    // {
    //     // self::bootKernel();
    //
    //     $client = static::createClient();
    //     $client->request('GET', '/');
    //
    //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    // }

    public function testTextIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Välkommen!');
    }
}
