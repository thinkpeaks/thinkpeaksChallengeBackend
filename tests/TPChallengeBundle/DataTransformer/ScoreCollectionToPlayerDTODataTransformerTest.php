<?php


namespace App\Tests\TPChallengeBundle\DataTransformer;


use App\TPChallengeBundle\DataTransformer\ScoreCollectionToPlayerDTODataTransformer;
use App\TPChallengeBundle\Entity\Score;

class ScoreCollectionToPlayerDTODataTransformerTest extends \PHPUnit\Framework\TestCase
{
    public function testTransformThrowExceptionIfEmptyArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transformer = new ScoreCollectionToPlayerDTODataTransformer();
        $transformer->transform([]);
    }

    public function testTransformThrowExceptionIfOneOfTheArrayElementHasNotTheRightClass()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transformer = new ScoreCollectionToPlayerDTODataTransformer();
        $transformer->transform([
            new \stdClass()
        ]);
    }

    public function testTransformSucceedWithACoupleOfScoreEntities()
    {
        $scores = [
            $this->getScoreEntity('david@email2.com', 'Dav', 'VanElst', 'DVE', '2018-06-03T06:55:11+01:00', 9984),
            $this->getScoreEntity('davidvelst@email.com', 'David', 'Ve', 'DVE', '2020-08-03T02:19:10+01:00', 450), // most recent
            $this->getScoreEntity('david@email.com', 'David', 'Vander Elst', 'DVE', '2020-09-04T05:33:10+01:00', 1121),
            $this->getScoreEntity('david.ve@email.com', 'Davdi', 'velst', 'DVE', '2019-02-03T02:19:10+01:00', 71),
        ];

        $transformer = new ScoreCollectionToPlayerDTODataTransformer();
        $player = $transformer->transform($scores);
        $arrayPlayer = $player->toArray();

        $this->assertSame('DVE', $arrayPlayer['nickname'], 'Nickname should be the same as the input');
        $this->assertSame('David', $arrayPlayer['firstname'], 'Firstname should be the most recent used');
        $this->assertSame('Vander Elst', $arrayPlayer['lastname'], 'Lastname should be the most recent used');
        $this->assertSame('david@email.com', $arrayPlayer['email'], 'Lastname should be the most recent used');
        $this->assertSame('2018-06-03T06:55:11+01:00', $arrayPlayer['created_date'], 'Created date should be the oldest date');
        $this->assertSame('2020-09-04T05:33:10+01:00', $arrayPlayer['last_played_date'], 'Last played date should be the newest date');
        $this->assertSame(9984, $arrayPlayer['highest_score'], 'Highest score should be the highest score of the array');
        $this->assertSame(2907, $arrayPlayer['avg_score'], 'AVG score should the AVG of all scores in the array');
        $this->assertSame(4, $arrayPlayer['total_played'], 'Total played should be the count of the array passed');
    }

    public function testTransformThrowExceptionIfOneOfTheArrayElementHasNotTheSameNickName()
    {
        $this->expectException(\InvalidArgumentException::class);

        $scores = [
            $this->getScoreEntity('david@email2.com', 'Dav', 'VanElst', 'DVE', '2018-06-03T06:55:11+01:00', 9984),
            $this->getScoreEntity('davidvelst@email.com', 'David', 'Ve', 'DVE_BIS', '2020-08-03T02:19:10+01:00', 450)
        ];

        $transformer = new ScoreCollectionToPlayerDTODataTransformer();
        $transformer->transform($scores);
    }

    // Test coutnable param
    public function testTransformThrowExceptionIfTheDataPassedIsNotCountable()
    {
        $this->expectException(\InvalidArgumentException::class);
        $scores = 123;
        $transformer = new ScoreCollectionToPlayerDTODataTransformer();
        $transformer->transform($scores);
    }

    private function getScoreEntity(string $email, string $firstname, string $lastname, string $nickname, string $date, int $score)
    {
        return (new Score())
            ->setEmail($email)
            ->setUniqueId(substr(md5(rand(0,9999999999)), 0, 13))
            ->setScore($score)
            ->setNickName($nickname)
            ->setFirstName($firstname)
            ->setLastName($lastname)
            ->setIsArchived(false)
            ->setIsSpecialGuest(false)
            ->setWhitoutFrontend(false)
            ->setCreatedAt(new \DateTime($date))
            ->setUpdatedAt(new \DateTime($date))
        ;
    }
}
