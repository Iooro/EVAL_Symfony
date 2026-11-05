<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BenevoleControllerTest extends WebTestCase
{
    public function testNewFormRenders(): void
    {
        $client = static::createClient();
        $client->request('GET', '/benevole/new');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('input[name="benevole[email]"]');
    }
}
