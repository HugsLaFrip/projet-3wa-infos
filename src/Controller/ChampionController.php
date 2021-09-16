<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\DiscussionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChampionController extends AbstractController
{
    /**
     * @Route("/champion", name="champion")
     */
    public function index(DiscussionRepository $discussionRepository, CommentRepository $commentRepository): Response
    {
        $discussion = $discussionRepository->findTop3();
        $comment = $commentRepository->findTop3();

        return $this->render('champion/index.html.twig', [
            'discussion' => $discussion,
            'comment' => $comment
        ]);
    }
}
