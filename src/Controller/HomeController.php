<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, OeuvreRepository $oeuvreRepository): Response
    {
        $etat = $request->query->getString('etat');
        $oeuvres = $etat === 'existantes'? $oeuvreRepository->findBy(['est_detruite' => false]) : $oeuvreRepository->findAll();
        return $this->render('home/index.html.twig', [
            'oeuvres' => $oeuvreRepository->findAll(),
        ]);
    }
}
