<?php

namespace App\TPChallengeBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\TPChallengeBundle\Entity\Score;
use App\TPChallengeBundle\Form\ScoreType;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;

class ApiController extends AbstractFOSRestController
{
    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('TPChallengeBundle:Default:index.html.twig');
    }

    /**
     * Create a new score from the submitted data.
     *
     * @Post("/scores")
     * @Annotations\View(statusCode = Response::HTTP_BAD_REQUEST)
     * @param Request $request
     * @return View
     */
    public function postScoreAction(Request $request): View
    {
        $score = new Score();
        $form = $this->createForm(ScoreType::class, $score, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $emailInBase64 = base64_encode($email);

            if ($this->validateToken($emailInBase64, $form->get('token')->getData())) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($score);
                $em->flush();

                $routeOptions = [
                    'uniqueId' => $score->getUniqueId(),
                    '_format' => $request->get('_format')
                ];

                $view = $this->view($score, Response::HTTP_CREATED);
                $view->setRoute('app_tpchallenge_api_getscore');
                $view->setRouteParameters($routeOptions);

                return $view;
            } else {
                throw new HttpException(401, "You didn't say the magic word.");
            }
        }

        return $this->view(['form' => $form], 400);
    }

    /**
     * Get token for a specific email.
     *
     * @Get("/token/{base64email}")
     * @param string $base64email the person email
     * @return View
     */
    public function getTokenAction(string $base64email): View
    {
        return $this->view(['token' => $this->getToken($base64email)]);
    }

    /**
     * Get score information for a specific email.
     *
     * @Get("/scores/{uniqueId}")
     * @param string $uniqueId
     * @return View
     */
    public function getScoreAction(string $uniqueId): View
    {
        $scores = $this->getDoctrine()->getRepository('TPChallengeBundle:Score')->findByUniqueId($uniqueId);

        if ($scores === null) {
            throw $this->createNotFoundException("No participation found for this uniqueId.");
        }
        return $this->view($scores);
    }

    /**
     * Add extra points using custom secret endpoint.
     *
     * @Get("/score/extra/{base64email}/{magicToken}")
     * @param string $base64email
     * @param string $magicToken
     * @return View
     */
    public function getScoreExtraAction(string $base64email, string $magicToken): View
    {
        $em = $this->getDoctrine()->getManager();
        $email = base64_decode($base64email);

        if ($magicToken == hash('sha512', $email . "cocoLapin")) {
            $em->createQuery('
                UPDATE App\TPChallengeBundle\Entity\Score s
                SET s.isArchived = 1,s.whitoutFrontend=1,s.score=s.score+2000
                WHERE s.email=:email AND s.whitoutFrontend IS NULL
            ')
                ->execute(['email' => $email])
            ;

            return $this->view(["gg" => 'points added for email']);

        } else {
            throw $this->createNotFoundException("No participation found for this uniqueId.");
        }
    }

    /**
     * Get 10 most High scores
     *
     * @Get("/highscores")
     * @return View
     */
    public function getHighScoresAction(): View
    {
        $result = [];
        $entityManager = $this->getDoctrine()->getManager();

        $query = $entityManager->createQuery("
            SELECT s
            FROM TPChallengeBundle:Score s
            WHERE s.isArchived != :bool
            ORDER BY s.score DESC            
        ")
            ->setParameter('bool', true)
            ->setMaxResults(10)
        ;
        $scores = $query->getResult();

        if ($scores === null) {
            throw $this->createNotFoundException("No participation found for this uniqueId.");
        } else {
            foreach ($scores as $pos => $score) {
                $result[] = [
                    'position' => $pos,
                    'nickName' => $score->getNickName(),
                    'score' => $score->getScore()
                ];
            }
        }

        return $this->view($result);
    }

    /**
     * Get token for a specific email.
     *
     * @param string $base64email the person email encoded in base64
     * @return string
     */
    protected function getToken(string $base64email): string
    {
        $email = base64_decode($base64email);
        $repository = $this->getDoctrine()->getRepository('TPChallengeBundle:Score');
        $lastScore = $repository->findBy(
            ['email' => $email],
            ['id' => 'DESC'],
            1
        );
        $uniqueId = "new";

        if ($lastScore !== null) {
            foreach ($lastScore as $key => $score) {
                $uniqueId = $score->getUniqueId();
            }
        }

        $secret = $_ENV['APP_SECRET'] ?? null;
        return hash('sha512', $email . $uniqueId . $secret);
    }

    /**
     * validate token for a specific email.
     *
     * @param string $base64email
     * @param string $frontendToken
     * @return bool
     */
    protected function validateToken(string $base64email, string $frontendToken): bool
    {
        $frontendSecret = $_ENV['APP_FRONTEND_SECRET'] ?? null;
        $backendToken = $this->getToken($base64email);
        $concat = hash('sha512', $backendToken . $frontendSecret);
        return ($frontendToken == $concat);
    }
}
