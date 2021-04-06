<?php

namespace App\Controller;

use App\Repository\JeuxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListingController extends AbstractController
{
    /**
     * @Route("/listing", name="listing")
     */
    public function index(JeuxRepository $jeuxRepository, Request $request): Response
    {

        $jeux = $jeuxRepository->findAll();

        return $this->render('listing/index.html.twig', [
            'Jeux' => $jeux,
        ]);
    }
}
