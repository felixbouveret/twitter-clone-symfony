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
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);
        $user = $this->getUser();
        $tweets = $repository->findBy(["user" => $user]);

        return $this->render('profile/index.html.twig', [
            'tweets' => $tweets,
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/{id}", name="otherUserProfile")
     */
    public function otherUser($id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Tweets::class);
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(["id" => $id]);
        $tweets = $repository->findBy(["user" => $user]);

        return $this->render('profile/index.html.twig', [
            'tweets' => $tweets,
            'user' => $user
        ]);
    }
}
