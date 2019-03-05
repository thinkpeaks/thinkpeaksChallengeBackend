<?php

namespace TPChallengeBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Psr\Log\Test\LoggerInterfaceTest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TPChallengeBundle\Entity\Score;
use TPChallengeBundle\Form\ScoreType;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use Psr\Log\LoggerInterface;


class ApiController extends FOSRestController
{
    public function indexAction()
    {
        return $this->render('TPChallengeBundle:Default:index.html.twig');
    }

    /**
     * Create a new score from the submitted data.
     *
     * @Annotations\View(
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
     *
     * @Post("/scores")
     *
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postScoreAction(Request $request)
    {

        $score = new Score();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ScoreType::class, $score, array());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $frontendToken = $form->get('token')->getData();
            $email = $form->get('email')->getData();
            $emailInBase64 = base64_encode($email);

            if ($this->validateToken($emailInBase64, $form->get('token')->getData())) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($score);
                $em->flush();

                $routeOptions = array(
                    'uniqueId' => $score->getUniqueId(),
                    '_format' => $request->get('_format')
                );

                $view = $this->view($score, Response::HTTP_CREATED);
                $view->setRoute('get_score');
                $view->setRouteParameters($routeOptions);

                return $view;
            } else {


                throw new HttpException(401, "You didn't say the magic word.");

            }
        }

        return $this->view(array('form' => $form), 400);

    }

    /**
     * Get token for a specific email.
     *
     *
     * @Get("/token/{base64email}")
     *
     * @return \FOS\RestBundle\View\View
     *
     * @param Request $request the request object
     * @param string $email the person email
     *
     */
    public function getTokenAction(Request $request, $base64email)
    {
        return $this->view(array('token' => $this->getToken($base64email)));
    }


    /**
     * Get token for a specific email.
     *
     * @param string $base64email the person email encoded in base64
     *
     */
    protected function getToken($base64email)
    {

        $email = base64_decode($base64email);

        $em = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository('TPChallengeBundle:Score');
        $lastscore = $repository->findBy(array('email' => $email), array('id' => 'DESC'), 1);

        if ($lastscore === null) {
            $uniqueId = "new";
        } else {

            foreach ($lastscore as $key => $score) {
                $uniqueId = $score->getUniqueId();

            }
        }

        $secret = $this->container->getParameter('secret');

        return hash('sha512', $email . $uniqueId . $secret);
    }

    /**
     * validate token for a specific email.
     * @param string $email the person email
     *
     */
    protected function validateToken($base64email, $frontendToken)
    {
        $frontendSecret = $this->container->getParameter('frontend_secret');
        $backentToken = $this->getToken($base64email);

        $concat = hash('sha512', $backentToken . $frontendSecret);


        return ($frontendToken == $concat);
    }

    /**
     * Get score information for a specific email.
     *
     * @Get("/scores/{uniqueId}")
     *
     * @return \FOS\RestBundle\View\View
     *
     * @param Request $request the request object
     * @param string $email the person email
     *
     */
    public function getScoreAction(Request $request, $uniqueId)
    {


        $em = $this->getDoctrine()->getManager();

        $scores = $this->getDoctrine()->getRepository('TPChallengeBundle:Score')->findByUniqueId($uniqueId);

        if ($scores === null) {
            throw $this->createNotFoundException("No participation found for this uniqueId.");
        }


        return $this->view($scores);


        // ... return a JSON response with the post
    }


    /**
     * Get 10 most High scores
     *
     *
     * @param Request $request the request object
     *
     * @Get("/highscores")
     *
     * @return \FOS\RestBundle\View\View
     *
     *
     */
    public function getHighScoresAction(Request $request)
    {

        $result = array();


        $repository = $this->getDoctrine()->getRepository(Score::class);

        $scores = $repository->findBy(array(), array('score' => 'DESC'), 10);


        if ($scores === null) {
            throw $this->createNotFoundException("No participation found for this uniqueId.");
        } else {
            $i = 0;
            foreach ($scores as $score) {

                $result[] = array('position' => $i, 'nickName' => $score->getNickName(), 'score' => $score->getScore());
                $i++;
            }
        }

        return $this->view($result);


        // ... return a JSON response with the post
    }
}
