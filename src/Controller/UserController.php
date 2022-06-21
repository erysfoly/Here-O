<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Entity\User;
use App\Form\DeleteAccountFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public const DELETE_ACCOUNT_SENTENCE = "Je veux supprimer mon compte";

    /**
     * @Route("/profile", name="user_profile")
     */
    public function indexAction(ManagerRegistry $doctrine): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        return $this->render(
            'user/profile.html.twig',
            [
                'user' => $currentUser,
                'createdQuests' => $currentUser->getCreatedQuests(),
                'participatingQuests' => $currentUser->getParticipatingQuests(),
            ]
        );
    }

    /**
     * @Route("/profile/delete-account", name="delete_account")
     */
    public function deleteAccountAction(Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(DeleteAccountFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $this->container->get('security.token_storage')->setToken(null);

            $entityManager = $doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', 'Ton compte a bien été supprimé !');

            return $this->redirectToRoute('index');
        }

        return $this->render('user/delete_account.html.twig', [
            'deleteAccountForm' => $form->createView(),
        ]);
    }
}