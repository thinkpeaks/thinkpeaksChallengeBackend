<?php

namespace App\TPChallengeBundle\Controller;

use App\TPChallengeBundle\DataTransformer\ScoreCollectionToPlayerDTODataTransformer;
use App\TPChallengeBundle\DataTransformer\ScoreEntityToGameDTODataTransformer;
use App\TPChallengeBundle\Entity\Score;
use App\TPChallengeBundle\Repository\ScoreRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class PlayerController extends AbstractFOSRestController
{
    /**
     * Get global score stats
     * @Get("/players/{nickname}")
     * @param string $nickname
     * @param ScoreCollectionToPlayerDTODataTransformer $dataTransformer
     * @return View
     */
    public function getPlayerData(string $nickname, ScoreCollectionToPlayerDTODataTransformer $dataTransformer): View
    {
        $playerScores = $this->getScoreRepository()->findPlayerGamesByNickname($nickname);
        return $this->view([
            'player' => $dataTransformer->transform($playerScores)->toArray()
        ]);
    }

    /**
     * Get list of games for a giver nickname
     * @Get("/players/{nickname}/games")
     * @param string $nickname
     * @param ScoreEntityToGameDTODataTransformer $dataTransformer
     * @return View
     */
    public function getPlayerGames(string $nickname, ScoreEntityToGameDTODataTransformer $dataTransformer): View
    {
        $playerScores = $this->getScoreRepository()->findPlayerGamesByNickname($nickname);
        $playerGames = [];

        foreach($playerScores as $score) {
            $playerGames[] = $dataTransformer->transform($score)->toArray();
        }

        return $this->view([
            'games' => $playerGames
        ]);
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return $this->container->get('doctrine')->getManager();
    }

    /**
     * @return ScoreRepository
     */
    private function getScoreRepository(): ScoreRepository
    {
        return $this->getEntityManager()->getRepository(Score::class);
    }
}
