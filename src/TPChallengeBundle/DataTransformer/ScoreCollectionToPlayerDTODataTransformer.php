<?php


namespace App\TPChallengeBundle\DataTransformer;

use App\TPChallengeBundle\DTO\Player;
use App\TPChallengeBundle\Entity\Score;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ScoreCollectionToPlayerDTODataTransformer implements \Symfony\Component\Form\DataTransformerInterface
{

    /**
     * @inheritDoc
     * @param Score[]|array $scores
     * @return Player
     */
    public function transform($scores)
    {
        // Find the oldest and newest score to retrieve data from the correct one
        // Newest data are used to define the name of the player
        // Oldest data to define the createdDate of the player
        $oldestDate = $newestDate = $oldestScore = $newestScore = null;
        $highscore = $avgScore = 0;

        foreach($scores as $score) {
            if(is_null($oldestDate) || $oldestDate > $score->getCreatedAt()) {
                $oldestDate = $score->getCreatedAt();
                $oldestScore = $score;
            }

            if(is_null($newestDate) || $newestDate < $score->getCreatedAt()) {
                $newestDate = $score->getCreatedAt();
                $newestScore = $score;
            }

            if($highscore < $score->getScore()) {
                $highscore = $score->getScore();
            }

            $avgScore += $score->getScore();
        }

        $avgScore = round($avgScore / count($scores));

        // Now create the DTO
        $player = new Player();
        $player
            ->setFirstname($newestScore->getFirstName())
            ->setLastname($newestScore->getLastName())
            ->setNickname($newestScore->getNickName())
            ->setEmail($newestScore->getEmail())
            ->setCreatedDate(\DateTimeImmutable::createFromMutable($oldestDate))
            ->setLastPlayedDate(\DateTimeImmutable::createFromMutable($newestDate))
            ->setTotalPlayed(count($scores))
            ->setHighestScore($highscore)
            ->setAvgScore($avgScore)
        ;

        return $player;
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        throw new \RuntimeException('Reverse transform is not yet supported. We should use the nickname to retrieve the data from DB.');
    }
}
