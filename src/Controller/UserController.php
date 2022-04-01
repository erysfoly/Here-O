<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user_profile")
     */
    public function indexAction(ManagerRegistry $doctrine): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $quests = $doctrine->getRepository(Quest::class)->findBy(["author" => $currentUser]);

        return $this->render(
            'user/profile.html.twig',
            [
                'user' => $currentUser,
                'quests' => $quests,
            ]
        );
    }
}