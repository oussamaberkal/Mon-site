<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @Route("/article/{id<\d+>}", name="article")
     */
    public function index(JeuxRepository $jeuxRepository, $id): Response
    {

        $jeux = $jeuxRepository->find($id);

        if (!$this->session->has('viewed_game'. $jeux->getId(), $jeux->getId())) {
            $vues = $jeux->getVuesJeux();
            $vues ++;
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeux->setVuesJeux($vues));
            $em->flush();
            $this->session->set('viewed_game'. $jeux->getId(), $jeux->getId());
        }
        else {
            $vues = $jeux->getVuesJeux();
            $vues;
            $jeux->setVuesJeux($vues);
            $em = $this->getDoctrine()->getManager();
            $em->persist($jeux->setVuesJeux($vues));
            $em->flush();
        }

        return $this->render('article/index.html.twig', [
            'Jeux' => $jeux,
        ]);
    }
}



    
