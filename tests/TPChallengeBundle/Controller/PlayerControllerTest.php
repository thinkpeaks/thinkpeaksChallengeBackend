<?php

namespace App\Tests\TPChallengeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class PlayerControllerTest extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testGetSpecificPlayerDataWithUnexistingNickNameReturn404NotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/api/players/UnknownNickname', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testGetSpecificPlayerDataWithExistingNickNameReturnsPlayerData()
    {
        $client = static::createClient();
        $client->request('GET', '/api/players/SuperNick', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame(
            [
                'player' => [
                    'nickname' => 'SuperNick',
                    'firstname' => 'Super',
                    'lastname' => 'Man',
                    'email' => 'supernick@localhost',
                    'created_date' => '2017-02-01T02:10:10+01:00',
                    'last_played_date' => '2020-02-01T02:10:10+01:00',
                    'highest_score' => 9877,
                    'avg_score' => 4554,
                    'total_played' => 3,
                ],
            ],
            $data
        );
    }

    public function testGetSpecificPlayerGamesWithUnexistingNickNameReturns404NotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/api/players/UnknownNickname/games', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function testGetSpecificPlayerGamesWithExistingNickNameReturnsAllGamesData()
    {
        $client = static::createClient();
        $client->request('GET', '/api/players/SuperNick/games', [], [], ['HTTP_ACCEPT' => 'application/json']);
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertSame('SuperNick', $data['games'][0]['player_nickname']);
        $this->assertSame('2020-02-01T02:10:10+01:00', $data['games'][0]['date']);
        $this->assertSame(1892, $data['games'][0]['score']);
        $this->assertRegExp('/^([a-f0-9]+)$/', $data['games'][0]['unique_id']);

        $this->assertSame('SuperNick', $data['games'][1]['player_nickname']);
        $this->assertSame('2020-01-01T02:10:10+01:00', $data['games'][1]['date']);
        $this->assertSame(9877, $data['games'][1]['score']);
        $this->assertRegExp('/^([a-f0-9]+)$/', $data['games'][1]['unique_id']);

        $this->assertSame('SuperNick', $data['games'][2]['player_nickname']);
        $this->assertSame('2017-02-01T02:10:10+01:00', $data['games'][2]['date']);
        $this->assertSame(1892, $data['games'][2]['score']);
        $this->assertRegExp('/^([a-f0-9]+)$/', $data['games'][2]['unique_id']);
    }
}
