<?php


namespace App\TPChallengeBundle\DataTransformer;

use App\TPChallengeBundle\DTO\Game;
use App\TPChallengeBundle\DTO\Player;
use App\TPChallengeBundle\Entity\Score;

class ScoreEntityToGameDTODataTransformer implements \Symfony\Component\Form\DataTransformerInterface
{

    /**
     * @inheritDoc
     * @param Score $score
     * @return Player
     */
    public function transform($score)
    {
        if(get_class($score) !== Score::class) {
            throw new \InvalidArgumentException('Score class should be ' . Score::class);
        }

        $game = new Game();
        $game
            ->setUniqueId($score->getUniqueId())
            ->setDate(\DateTimeImmutable::createFromMutable($score->getCreatedAt()))
            ->setPlayerNickname($score->getNickName())
            ->setScore($score->getScore())
        ;
        return $game;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        throw new \RuntimeException('Reverse transform is not yet supported. We should use the uniqueId to retrieve the data from DB.');
    }
}
