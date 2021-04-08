<?php

namespace App\Controller;

use App\Entity\AboNewsletter;
use App\Form\AboNewsletterType;
use App\Entity\User;
use App\Form\ModifyEmailType;
use App\Form\ModifyPasswordType;
use App\Form\ModifyPseudoType;
use PhpParser\Node\Stmt\ElseIf_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        return $this->render('base/home.html.twig', [
        ]);
    }

    /**
     * @Route("/a-propos", name="about")
     */
    public function about(): Response
    {
        return $this->render('base/about.html.twig');
    }



    public function header(string $routeName)
    {
        return $this->render('base/_header.html.twig', [
            'route_name' => $routeName,
        ]);
    }



     /**
     * @Route("/newsletter-subscribe", name="newsletter-subscribe")
     */
    public function newsletterSubscribe(Request $request)
    {
        $aboNewsletter = new AboNewsletter();
        $form = $this->createForm(AboNewsletterType::class, $aboNewsletter);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
        }
        return $this->redirect($request->headers->get('referer'));
    }


    public function footer(Request $request)
    {

        $aboNewsletter = new AboNewsletter();
        $form = $this->createForm(AboNewsletterType::class, $aboNewsletter);

        return $this->render('base/_footer.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/redirect-user", name="redirect_user")
     */
    public function redirectUser()
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('espace');
        } else {
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/change-locale/{locale}r", name="change_locale")
     */
    public function changeLocale(string $locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);
        $pathhome = $this->generateUrl('home');
        $referer = $request->headers->get('referer',$pathhome);
        return $this->redirect($referer);

    }


    /**
     * @Route("/mon-espace", name="espace")
     */
    public function monEspace()
    {
        return $this->render('member/espace.html.twig', [
        ]);

    }



    /**
     * @Route("/redirect-espace", name="redirect-espace")
     */
    public function redirectEspace()
    {
      if($this->isGranted('ROLE_ADMIN')){

        return $this->redirectToRoute('espace');

      }
      elseif($this->isGranted('ROLE_MEMBER')){

        return $this->redirectToRoute('espace_membre');

      }
      else{

           return $this->redirectToRoute('home');
      }
    }





    /**
     * @Route("/espace-membre", name="espace_membre")
     */
    public function espaceMembre()
    {
        return $this->render('member/index.html.twig', [
        ]);

    }

    /**
     * @Route("/modifier_mdp", name="modifier_mdp")
     */
    public function modifierMdp(Request $request , UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(ModifyPasswordType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $current_password = $form->get('currentPassword')->getData();
        
            $new_password = $form->get('Password')->getData();
            $user = $this->getUser();
    
            $checkPass = $passwordEncoder->isPasswordValid($user,$current_password);

            if($checkPass === true){
               
                $user->setPassword($passwordEncoder->encodePassword($user,$new_password));
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('success', "Merci Votre mot de passe a bien été modifié");
                return $this->redirectToRoute('app_logout');
            }
            
            else{
             $this->addFlash('danger', "Ce n'est pas votre mot de passe!.");
            }
    
        }



        return $this->render('member/modifierMdp.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/modifier-pseudo", name="modifier-pseudo")
     */
    public function modifierPseudo(Request $request)
    {
        $form = $this->createForm(ModifyPseudoType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
             $user= $this->getUser();
             $user->setPseudo($form->get('pseudo')->getData());

             $em = $this->getDoctrine()->getManager();
             $em->flush();

             $this->addFlash('success' ,"Votre pseudonyme a bien été changé");


        }

        return $this->render('member/modifierPseudo.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/modifier-email", name="modifier-email")
     */
    public function modifierEmail(Request $request)
    {
        $form = $this->createForm(ModifyEmailType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
             $user= $this->getUser();
             $user->setEmail($form->get('email')->getData());

             $em = $this->getDoctrine()->getManager();
             $em->flush();

             $this->addFlash('success' ,"Votre email a bien été changé");


        }

        return $this->render('member/modifierEmail.html.twig', [
            'form' => $form->createView()
        ]);

    }








}
