<?php


namespace App\Tests\TPChallengeBundle\DataTransformer;


use App\TPChallengeBundle\DataTransformer\ScoreEntityToGameDTODataTransformer;
use App\TPChallengeBundle\Entity\Score;
use PHPUnit\Framework\TestCase;

class ScoreEntityToGameDTODataTransformerTest extends TestCase
{
    public function testTransformThrowExceptionIfNotTheGoodEntityClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        $score = new \stdClass();
        $transformer = new ScoreEntityToGameDTODataTransformer();
        $transformer->transform($score);
    }

    public function testTransformSucceed()
    {
        $transformer = new ScoreEntityToGameDTODataTransformer();

        $score = new Score();
        $score
            ->setEmail('somecoolemail@email.com')
            ->setUniqueId('123456ABCDEF')
            ->setScore(4545)
            ->setNickName('DVE')
            ->setFirstName('David')
            ->setLastName('Vander Elst')
            ->setIsArchived(false)
            ->setIsSpecialGuest(false)
            ->setWhitoutFrontend(false)
            ->setCreatedAt(new \DateTime('2020-02-01T02:10:10+01:00'))
            ->setUpdatedAt(new \DateTime('2020-02-01T02:10:10+01:00'))
        ;

        $game = $transformer->transform($score);

        $this->assertSame(
            [
                'unique_id' => '123456ABCDEF',
                'date' => '2020-02-01T02:10:10+01:00',
                'player_nickname' => 'DVE',
                'score' => 4545,
            ],
            $game->toArray()
        );
    }
}
