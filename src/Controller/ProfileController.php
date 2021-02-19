<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Tweets;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{userName}", name="profile")
     */
    public function index($userName): Response
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(["username" => $userName]);
        $tweets = $repository->findBy(["user" => $user]);

        return $this->render('profile/index.html.twig', [
            'tweets' => $tweets,
            'user' => $user
        ]);
    }

    /**
     * @Route("/follow/{userName}", name="follow")
     */
    public function follow($userName): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class)->findOneBy(["username" => $userName]);
        
        $userRepository->addFollower($user);
        $em->persist($userRepository);
        $em->flush();

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/unfollow/{userName}", name="unfollow")
     */
    public function unfollow($userName): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository(User::class)->findOneBy(["username" => $userName]);
        
        $userRepository->removeFollower($user);
        $em->persist($userRepository);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
