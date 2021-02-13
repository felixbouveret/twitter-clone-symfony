<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\Tweets;
use App\Form\TweetType;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);

        $tweets = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'tweets' => $tweets,
        ]);
    }

     /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $tweet = new Tweets();
        $form = $this->createForm(TweetType::class, $tweet);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            // TODO Set the current user
            $user = $this->getUser();
            $tweet->setIdUser($user);
            $tweet->setDate(new \DateTime('now'));

            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/create.html.twig', ['form' => $form->createView()]);
    }
}