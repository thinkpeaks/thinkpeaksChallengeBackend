<?php


namespace App\Tests\TPChallengeBundle\DTO;


use App\TPChallengeBundle\DTO\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testToArrayReturnsExpectedStructure()
    {
        $player = new Player();
        $player
            ->setFirstname('David')
            ->setLastname('Vander Elst')
            ->setNickname('DVE')
            ->setEmail('myemail@email.com')
            ->setCreatedDate(new \DateTimeImmutable('2020-01-01T00:00:00+01:00'))
            ->setAvgScore(2503)
            ->setTotalPlayed(15)
            ->setLastPlayedDate(new \DateTimeImmutable('2020-01-08T00:00:00+01:00'))
            ->setHighestScore(5430)
        ;

        $this->assertSame(
            [
                'nickname' => 'DVE',
                'firstname' => 'David',
                'lastname' => 'Vander Elst',
                'email' => 'myemail@email.com',
                'created_date' => '2020-01-01T00:00:00+01:00',
                'last_played_date' => '2020-01-08T00:00:00+01:00',
                'highest_score' => 5430,
                'avg_score' => 2503,
                'total_played' => 15,
            ],
            $player->toArray()
        );
    }
}
