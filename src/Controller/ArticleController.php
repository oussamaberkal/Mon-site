<?php

namespace App\Controller;

use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id<\d+>}", name="article")
     */
    public function index(JeuxRepository $jeuxRepository, $id): Response
    {

        $jeux = $jeuxRepository->find($id);

        return $this->render('article/index.html.twig', [
            'Jeux' => $jeux,
        ]);
    }
}
