<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use App\Entity\Jeux;
use App\Entity\Newsletter;
use App\Form\CategorieType;
use App\Form\JeuxType;
use App\Form\NewsletterType;
use App\Service\UploadService;
use App\Repository\CategorieRepository;
use App\Repository\JeuxRepository;
use App\Repository\NewsletterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    # Ajout Jeu + Categorie

    /**
     * @Route("/", name="espace_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', []);
    }

    /**
     * @Route("/admin/jeu/liste", name="liste_jeu")
     */
    public function ListeJeu(JeuxRepository $jeuxRepository)
    {

        $ListeJeux = $jeuxRepository->findAll();

        return $this->render('admin/jeu/listeJeu.html.twig', [
            'jeux' => $ListeJeux,
        ]);
    }

    /**
     * @Route("/admin/jeu/ajouter", name="ajouter_jeu")
     */
    public function ajouterJeu(Request $request)
    {

        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $fileName = $this->uploadService->uploadImage($image, $jeux);
                $jeux->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($jeux);
            $em->flush();

            $this->addFlash('success', "Le jeu a bien été créé.");
            return $this->redirectToRoute('liste_jeu');
        }

        return $this->render('admin/jeu/ajouterJeu.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/jeu/modifier/{id}", name="modifier_jeu")
     */
    public function ModifierJeu(Request $request, Jeux $jeux)
    {

        $form = $this->createForm(JeuxType::class, $jeux);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $fileName = $this->uploadService->uploadImage($image, $jeux);
                $jeux->setImage($fileName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', "Le jeu a bien été modifié.");
            return $this->redirectToRoute('liste_jeu');
        }


        return $this->render('admin/jeu/modifierJeu.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/jeu/supprimer/{{id}}", name="suppimer_jeu")
     */
    public function SupprimerJeu(Jeux $jeux)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($jeux);
        $em->flush();

        $this->addFlash('success', "Le jeu a bien été supprimée.");
        return $this->redirectToRoute('liste_jeu');
    }

    /**
     * @Route("/admin/categorie/liste", name="liste_categorie")
     */
    public function ListeCategorie(CategorieRepository $categorieRepository)
    {

        $ListeCategorie = $categorieRepository->findAll();

        return $this->render('admin/categorie/listeCategorie.html.twig', [
            'categories' => $ListeCategorie,
        ]);
    }

    /**
     * @Route("/admin/categorie/ajouter", name="ajouter_categorie")
     */
    public function ajouterCategorie(Request $request)
    {

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', "La catégorie a bien été créé.");
            return $this->redirectToRoute('liste_categorie');
        }

        return $this->render('admin/categorie/ajouterCategorie.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/categorie/supprimer/{{id}}", name="suppimer_categorie")
     */
    public function SupprimerCategorie(Categorie $categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        $this->addFlash('success', "La catégorie a bien été supprimée.");
        return $this->redirectToRoute('liste_categorie');
    }

    # Newsletter

    /**
     * @Route("/admin/newsletter/liste", name="liste_newsletter")
     */
    public function ListeNewsletter(NewsletterRepository $newsletterRepository)
    {

        $ListeNewsletter = $newsletterRepository->findAll();

        return $this->render('admin/newsletter/listeNewsletter.html.twig', [
            'newsletters' => $ListeNewsletter,
        ]);
    }

    /**
     * @Route("/admin/newsletter/cree", name="cree_newsletter")
     */
    public function CreeNewsletter(Request $request)
    {

        $newsletter = new Newsletter();
        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();

            $this->addFlash('success', "La newsletter a bien été enregistrée.");
            return $this->redirectToRoute('liste_newsletter');
        }

        return $this->render('admin/newsletter/creeNewsletter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/newsletter/modifier/{id}", name="modifier_newsletter")
     */
    public function ModifierNewsletter(Request $request, Newsletter $newsletter)
    {

        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('success', "La newsletter a bien été modifié.");
            return $this->redirectToRoute('liste_newsletter');
        }


        return $this->render('admin/newsletter/modifierNewsletter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/newsletter/supprimer/{{id}}", name="suppimer_newsletter")
     */
    public function SupprimerNewsletter(Newsletter $newsletter)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($newsletter);
        $em->flush();

        $this->addFlash('success', "La newsletter a bien été supprimée.");
        return $this->redirectToRoute('liste_newsletter');
    }
}
