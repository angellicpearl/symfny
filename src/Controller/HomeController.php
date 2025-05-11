<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuteurRepository;
use App\Repository\LivreRepository;
use App\Repository\GenreRepository;
use App\Repository\EmpruntRepository;  // N'oublie pas d'importer ton EmpruntRepository

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]

    
    public function index(LivreRepository $livreRepo, AuteurRepository $auteurRepo, GenreRepository $genreRepo, EmpruntRepository $empruntRepo): Response
    {
        $livres = $livreRepo->findBy([], ['id' => 'DESC'], 5); // 5 derniers livres
        $auteurs = $auteurRepo->findAll();
        $genres = $genreRepo->findAll();
        $emprunts = $empruntRepo->findBy([], ['dateEmprunt' => 'DESC'], 5); // Derniers emprunts

        return $this->render('home/index.html.twig', [
            'livres' => $livres,
            'auteurs' => $auteurs,
            'genres' => $genres,
            'emprunts' => $emprunts,  // Ajout des emprunts
        ]);
    }
    
}
