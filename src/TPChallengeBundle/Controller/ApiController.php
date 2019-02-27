<?php

namespace TPChallengeBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
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
        }

        return $this->view(array('form' => $form), 400);

    }


    /**
     * Get score information for a specific email.
     *
     * @Annotations\View(
     *   statusCode = Response::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request the request object
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
}
