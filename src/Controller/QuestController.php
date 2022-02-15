<?php

namespace App\Controller;

use App\Entity\Quest;
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

            $quest = $form->getData();
            $quest->setPeopleNumber(0);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($quest);
            $entityManager->flush();

            $this->addFlash(
                "success",
                'La quête "' . $quest->getTitle() . '" a bien été créée.'
            );

            return $this->redirectToRoute("quest_all");
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
            'quest/list.html.twig',
            [
                'quests' => $quests,
            ]
        );
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
        $entityManager = $doctrine->getManager();
        $quest = $doctrine->getRepository(Quest::class)->find($id);

        $quest->setPeopleNumber($quest->getPeopleNumber()+1);

        $entityManager->flush();
        $this->addFlash(
            "success",
            'Ta participation à la quête "' . $quest->getTitle() . '" a bien été enregistrée.'
        );

        return $this->redirect($this->generateUrl('quest_all'));
    }
}