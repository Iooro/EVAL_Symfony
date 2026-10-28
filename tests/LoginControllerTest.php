<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginForm(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();
        self::assertSelectorExists('form[method="post"]');
        self::assertSelectorExists('input[name="_username"][type="email"]');
        self::assertSelectorExists('input[name="_password"][type="password"]');
        self::assertSelectorExists('input[name="_csrf_token"]');
    }
}
