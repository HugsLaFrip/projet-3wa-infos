<?php

namespace App\Controller;

use App\Repository\CategoryGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryGroupRepository $groupRespository): Response
    {
        return $this->render('home/index.html.twig', [
            'groups' => $groupRespository->findAll(),
        ]);
    }
}
