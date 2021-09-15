<?php

namespace App\Controller;

use App\Repository\CategoryGroupRepository;
use App\Repository\DiscussionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryGroupRepository $groupRespository, DiscussionRepository $discussionRepository): Response
    {
        // dd($discussionRepository->findOneBy([], ['createdAt' => 'DESC']));
        return $this->render('home/index.html.twig', [
            'groups' => $groupRespository->findAll(),
            'last_discussion' => $discussionRepository->findOneBy([], ['createdAt' => 'DESC'])
        ]);
    }
}
