<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeamControllerTest extends WebTestCase
{
    const API_URL_POST = '/api/team';
    const APPLICATION_JSON = 'application/json';
    const TEAM_NOT_FOUND = 'Team not found';


    public function testGetAllSuccess()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/teams');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetOneSuccess()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/team/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testGetOneFailNotFound()
    {
        $client = static::createClient();
        $client->request(
            'GET',
            '/api/team/1');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals(self::TEAM_NOT_FOUND, $client->getRequest()->getContent());
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
                    "name": "Andrés"
                    }');

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }

    public function testDeleteSuccess()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/team/2');

        $this->assertEquals(204, $client->getResponse()->getStatusCode());
        $this->assertEquals('Team deleted', $client->getResponse()->getContent());
    }

    public function testDeleteFail()
    {
        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/team/2');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertEquals('Team not found', $client->getResponse()->getContent());
    }

    public function testPatchSuccess()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/team/3',
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
            '/api/team/3',
            [],
            [],
            ['CONTENT_TYPE' => self::APPLICATION_JSON],
            '{name:"newName"}');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}