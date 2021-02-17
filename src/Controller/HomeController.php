<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
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

        $currentUser = $this->getUser();
        $followed = $currentUser->getFollowed();
        $followedTweets = [];

        foreach ($followed as $key => $follower) {
            array_push($followedTweets, $repository->findBy(["user" => $follower, 'isActivated' => true, "mainTweet" => null]));
        }

        $mergeFollowedTweets = array_merge(...$followedTweets);

        // dd($mergeFollowedTweets);

        return $this->render('home/index.html.twig', [
            'tweets' => $mergeFollowedTweets,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createTweet(Request $request)
    {
        $tweet = new Tweets();
        $form = $this->createForm(TweetType::class, $tweet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // TODO Set the current user
            $user = $this->getUser();
            $tweet->setUser($user);
            $tweet->setDate(new \DateTime('now'));

            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tweet/{id}", name="deleteTweet")
     */
    public function deleteTweet($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);
        $tweet = $repository->find($id);
        $tweet->setIsActivated(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tweet);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/answer/{id}", name="answerTweet")
     */
    public function answerTweet(Request $request, Tweets $mainTweet)
    {
        $tweet = new Tweets();
        $form = $this->createForm(TweetType::class, $tweet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            // TODO Set the current user
            $user = $this->getUser();
            $tweet->setUser($user);
            $tweet->setMainTweet($mainTweet);
            $tweet->setDate(new \DateTime('now'));

            $em->persist($tweet);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('home/create.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/like/{id}", name="likeTweet")
     */
    public function likeTweet($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $theTweet = $this->getDoctrine()->getRepository(Tweets::class)->find($id);
        $theTweet->addLike($user);

        $em->persist($theTweet);
        $em->flush();

        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/retweet/{id}", name="retweet")
     */
    public function retweet($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $theTweet = $this->getDoctrine()->getRepository(Tweets::class)->find($id);
        $theTweet->addRetweeter($user);
        $em->persist($theTweet);
        $em->flush();

        return $this->redirectToRoute('home');
    }
    /**
     * @Route("/deleteRetweet/{id}", name="deleteRetweet")
     */
    /*public function deleteRetweet($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $theTweet = $this->getDoctrine()->getRepository(Tweets::class)->find($id);
        $theTweet->removeRetweeter($user);
        $em->persist($theTweet);
        $em->flush();

        return $this->redirectToRoute('home');
    }*/
    /**
     * @Route("/dislike/{id}", name="dislikeTweet")
     */
    public function dislikeTweet($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $theTweet = $this->getDoctrine()->getRepository(Tweets::class)->find($id);
        $theTweet->removeLike($user);

        $em->persist($theTweet);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}