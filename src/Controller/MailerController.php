<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{

    /**
     * @Route("/email")
     */
    public function sendEmail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->to('erysfoly@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            return new Response($e, Response::HTTP_EXPECTATION_FAILED);
        }

        return new Response("Le mail s'est envoyé.", Response::HTTP_ACCEPTED);
    }
}