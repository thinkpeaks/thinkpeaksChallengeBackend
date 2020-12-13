<?php

namespace App\Tests\TPChallengeBundle\DTO;


use App\TPChallengeBundle\DTO\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testToArrayReturnsExpectedStructure()
    {
        $game = new Game();
        $game
            ->setScore(100)
            ->setPlayerNickname('David')
            ->setDate(new \DateTimeImmutable('2020-01-01T00:00:00+01:00'))
            ->setUniqueId('ABCD0123456')
        ;

        $this->assertSame(
            [
                'unique_id' => 'ABCD0123456',
                'date' => '2020-01-01T00:00:00+01:00',
                'player_nickname' => 'David',
                'score' => 100,
            ],
            $game->toArray()
        );
    }
}
