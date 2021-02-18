<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tweets;

class TweetController extends AbstractController
{
    /**
     * @Route("/tweetSingle/{tweetId}", name="tweetSingle")
     */
    public function index($tweetId): Response
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);
        $tweet = $repository->find($tweetId);
        $responses = $repository->findBy(["mainTweet" => $tweet]);

        return $this->render('tweetSingle/index.html.twig', [
            'tweet' => $tweet,
            'responses' => $responses
        ]);
    }
}
