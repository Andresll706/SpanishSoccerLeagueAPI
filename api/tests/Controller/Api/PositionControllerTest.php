<?php

namespace App\Tests\Controller\Api;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PositionControllerTest extends WebTestCase
{
    const API_URL = '/api/position';
    const APPLICATION_JSON = 'application/json';

    public function testGetAll(){
        $client = static::createClient();
        $client->request(
            'GET',
            self::API_URL,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{"name": ""}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());

    }

    public function testPostInvalidData()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            self::API_URL,
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
            self::API_URL,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testPostSucces()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            self::API_URL,
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{"name": "test"}');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}