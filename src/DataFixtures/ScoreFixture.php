<?php

namespace App\DataFixtures;

use App\TPChallengeBundle\Entity\Score;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ScoreFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $score = new Score();
        $score
            ->setEmail('supernick@localhost')
            ->setScore(1892)
            ->setNickName('SuperNick')
            ->setFirstName('Super')
            ->setLastName('Man')
            ->setIsArchived(false)
            ->setIsSpecialGuest(false)
            ->setWhitoutFrontend(false)
            ->setCreatedAt(new \DateTime('2020-02-01T02:10:10+01:00'))
            ->setUpdatedAt(new \DateTime('2020-02-01T02:10:10+01:00'))
        ;
        $manager->persist($score);

        $score = new Score();
        $score
            ->setEmail('supernick@localhost')
            ->setScore(9877)
            ->setNickName('SuperNick')
            ->setFirstName('Super')
            ->setLastName('Nick')
            ->setIsArchived(false)
            ->setIsSpecialGuest(false)
            ->setWhitoutFrontend(false)
            ->setCreatedAt(new \DateTime('2020-01-01T02:10:10+01:00'))
            ->setUpdatedAt(new \DateTime('2020-01-01T02:10:10+01:00'))
        ;
        $manager->persist($score);

        $score = new Score();
        $score
            ->setEmail('supernick@localhost')
            ->setScore(1892)
            ->setNickName('SuperNick')
            ->setFirstName('Sup')
            ->setLastName('N')
            ->setIsArchived(false)
            ->setIsSpecialGuest(false)
            ->setWhitoutFrontend(false)
            ->setCreatedAt(new \DateTime('2017-02-01T02:10:10+01:00'))
            ->setUpdatedAt(new \DateTime('2017-02-01T02:10:10+01:00'))
        ;
        $manager->persist($score);

        $manager->flush();
    }
}
