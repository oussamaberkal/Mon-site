<?php

namespace App\Controller;

use App\Entity\ContactPro;
use App\Form\ContactProType;
use App\Service\EmailService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_pro")
     */
    public function contactPro(Request $request, EmailService $emailService)
    {
        $contactPro = new ContactPro();
        $form = $this->createForm(ContactProType::class, $contactPro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactPro->setSentAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($contactPro);
            $em->flush();

            // Envoyé à l'admin
            $sentToAdmin = $emailService->send([
                'replyTo' => $contactPro->getEmail(),
                'subject' => '[CONTACT PRO] - ' . $contactPro->getSubject(),
                'template' => 'email/contact_pro.html.twig',
                'context' => [ 'contactPro' => $contactPro ],
            ]);

            // Accusé de réception
            $sentToContact = $emailService->send([
                'to' => $contactPro->getEmail(),
                'subject' => "Merci de nous avoir contacté",
                'template' => 'email/contact_pro_confirmation.html.twig',
                'context' => [ 'contactPro' => $contactPro ],
            ]);

            if ($sentToAdmin && $sentToContact) {
                $this->addFlash('success', "Merci de nous avoir contacté");
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('danger',"Une erreur est survenue pendant l'envoi d'email");
            }
        }

        return $this->render('contact/contact_pro.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
