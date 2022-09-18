<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    const API_URL_POST = '/api/player';
    const APPLICATION_JSON = 'application/json';
    const PLAYER_NOT_FOUND = '"Player not found"';


    public function testGetAllSuccess()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/players');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetOneSuccess()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/player/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetOneFailNotFound()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/player/13');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(self::PLAYER_NOT_FOUND, $client->getResponse()->getContent());

    }

    public function testPostInvalidData()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            self::API_URL_POST,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{"name": ""}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPostEmptyData()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            self::API_URL_POST,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPostSuccess()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            self::API_URL_POST,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{
                    "id": 5,
                    "name": "Andrés",
                    "age": 23,
                    "position": {
                        "0": {
                            "id": 1
                        }
                    },
                    "teamId": 1
                    }');

        $this->assertEquals("201", $client->getResponse()->getContent());
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testDeleteSuccess()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/player/2');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
        $this->assertEquals('Player deleted', $client->getResponse()->getContent());
    }

    public function testDeleteFail()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/player/23');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPatchSuccess()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/player/1',
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{name:"newName"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testPatchFail()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/player/34',
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{name:"newName"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}