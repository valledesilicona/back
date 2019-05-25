<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoomControllerTest extends WebTestCase
{

    public function testGetRooms()
    {

        $client = static::createClient();
        $client->request('GET', '/room/list');

        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue($result['success']);
        $this->assertTrue(is_array($result['items']));


    }


    public function testCreateRoom()
    {

        $payload = [

            'roomName' => 'TEST',
            'link' => 'magnet:?xt=urn:btih:1295fe180d708fb45f6e70ce21576a8cc099b4d6&dn=The Lion King 2 Simbas Pride (1998) 720p Bluray - 500MB - YIFY',
            'film_id' => 'TEST',
            'user' => 'TEST'

        ];

        $client = static::createClient();
        $client->request('POST', '/room/create', [], [], [], json_encode($payload));

        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertTrue($result['success']);


    }
}
