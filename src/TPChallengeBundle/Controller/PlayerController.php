<?php

namespace App\TPChallengeBundle\Controller;

use App\TPChallengeBundle\DataTransformer\ScoreCollectionToPlayerDTODataTransformer;
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
     * @Annotations\View(statusCode = Response::HTTP_BAD_REQUEST)
     * @Get("/players/{nickname}")
     * @param string $nickname
     * @param ScoreCollectionToPlayerDTODataTransformer $dataTransformer
     * @return View
     */
    public function getScoreStats(string $nickname, ScoreCollectionToPlayerDTODataTransformer $dataTransformer): View
    {
        $playerScores = $this->getScoreRepository()->findPlayerGamesByNickname($nickname);
        return $this->view(
            $dataTransformer
                ->transform($playerScores)
                ->toArray(),
            200
        );
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
