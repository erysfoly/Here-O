<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Entity\User;
use App\Form\EditQuestForm;
use App\Form\NewQuestForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/quest", name="quest_")
 */
class QuestController extends AbstractController
{

    /**
     * @Route("/new", name="new")
     */
    public function createAction(ManagerRegistry $doctrine, Request $request) {

        $form = $this->createForm(NewQuestForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Quest $quest */
            $quest = $form->getData();
            $quest->setAuthor($this->getUser());

            $entityManager = $doctrine->getManager();
            $entityManager->persist($quest);
            $entityManager->flush();

            $this->addFlash(
                "success",
                'La quête "' . $quest->getTitle() . '" a bien été créée.'
            );

            return $this->redirectToRoute("index");
        }

        return $this->renderForm(
            'quest/new.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/all", name="all")
     *
     * @param ManagerRegistry $doctrine
     *
     * @return Response
     */
    public function showAction(ManagerRegistry $doctrine): Response
    {
        $quests = $doctrine->getRepository(Quest::class)->findBy([], ['date' => 'ASC']);

        return $this->render(
            'quest/index.html.twig',
            [
                'quests' => $quests,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function updateAction(Request $request, ManagerRegistry $doctrine, $id) {

        $quest = $doctrine->getRepository(Quest::class)->find($id);

        if (!$quest) {
            throw $this->createNotFoundException(
                'Aucune quête ne correspond à l\'id ' . $id . '.'
            );
        }

        $form = $this->createForm(EditQuestForm::class, $quest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Quest $quest */
            $quest = $form->getData();

            $entityManager = $doctrine->getManager();
            $entityManager->persist($quest);
            $entityManager->flush();

            $this->addFlash(
                "success",
                'La quête "' . $quest->getTitle() . '" a bien été modifiée.'
            );

            return $this->redirectToRoute("index");
        }

        return $this->renderForm(
            'quest/edit.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/{id}/delete", name="delete")
     *
     * @param ManagerRegistry $doctrine
     * @param int $id
     * @return Response
     */
    public function deleteAction(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $quest = $doctrine->getRepository(Quest::class)->find($id);

        if (!$quest) {
            throw $this->createNotFoundException(
                'Aucune quête ne correspond à l\'id ' . $id . '.'
            );
        }

        $entityManager->remove($quest);
        $entityManager->flush();

        $this->addFlash(
            "success",
            'La quête "' . $quest->getTitle() . '" a bien été supprimée.'
        );

        return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/{id}/participate", name="participate")
     *
     * @param ManagerRegistry $doctrine
     * @param int $id
     *
     * @return Response
     */
    public function addPeopleToQuest(ManagerRegistry $doctrine, int $id): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute("app_login");
        }

        $entityManager = $doctrine->getManager();
        /** @var Quest $quest */
        $quest = $doctrine->getRepository(Quest::class)->find($id);

        $quest->addParticipant($this->getUser());

        $entityManager->flush();
        $this->addFlash(
            "success",
            'Ta participation à la quête "' . $quest->getTitle() . '" a bien été enregistrée.'
        );

        return $this->redirectToRoute("index");
    }
}