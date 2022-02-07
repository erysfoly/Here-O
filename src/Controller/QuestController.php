<?php

namespace App\Controller;

use App\Entity\Quest;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/quest", name="quest_")
 */
class QuestController extends AbstractController
{

    /**
     * @Route("/all", name="all")
     *
     * @param ManagerRegistry $doctrine
     *
     * @return Response
     */
    public function showAction(ManagerRegistry $doctrine): Response
    {
        $quests = $doctrine->getRepository(Quest::class)->findAll();

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
            'Your registration to the quest "' . $quest->getTitle() . '" has been successful.'
        );

        return $this->redirect($this->generateUrl('quest_all'));
    }
}