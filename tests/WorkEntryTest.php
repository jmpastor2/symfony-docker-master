<?php

namespace App\Test;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WorkEntryControllerTest extends WebTestCase
{
    public function testAddWorkEntry(): void
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/work-entries',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'start_date' => '2023-06-19 09:00:00',
                'end_date' => '2023-06-19 17:00:00',
            ])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testDeleteWorkEntry(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/work-entries/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

