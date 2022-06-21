<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @return void
     */
    public function contact(Request $request) : Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseSendingEmail = $this->sendEmail($form->getData());
            if ($responseSendingEmail){
                $this->addFlash(
                    "success",
                    'Ton message nous a bien été envoyé ! Nous te répondrons bientôt.'
                );
            } else {
                $this->addFlash(
                    "danger",
                    'Le message ne s\'est pas envoyé. Erreur : \n' . $responseSendingEmail
                );
            }

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

    /**
     * @return bool|Exception|TransportExceptionInterface
     */
    public function sendEmail(array $emailData)
    {
        $teamMailAddress = new Address('hereo.team@gmail.com', 'Here#O Team');
        $email = (new TemplatedEmail())
            ->from($teamMailAddress)
            ->replyTo(new Address($emailData["email"], $emailData["name"]))
            ->to($teamMailAddress)
            ->subject($emailData["subject"])
            ->htmlTemplate('contact/email.html.twig')
            ->context([
                'message'   => $emailData["message"],
                'name'    => $emailData["name"],
            ])
        ;

        $emailCopy = (new TemplatedEmail())
            ->from($teamMailAddress)
            ->to(new Address($emailData["email"], $emailData["name"]))
            ->subject("Merci pour ton message : " . $emailData["subject"])
            ->htmlTemplate('contact/email.html.twig')
            ->context([
                'message' => $emailData["message"],
                'name'    => $emailData["name"],
                'copy'    => true,
            ])
        ;

        try {
            $this->mailer->send($email);
            $this->mailer->send($emailCopy);
            return true;
        } catch (TransportExceptionInterface $exception) {
            return $exception;
        }
    }
}