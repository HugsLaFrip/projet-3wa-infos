<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\Discussion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{discussion}", name="comment")
     * @ParamConverter("discussion", options={"mapping": {"discussion": "slug"}})
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $request, Discussion $discussion): Response
    {
        $form = $this->createForm(CommentType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $comment->setUser($this->getUser());
            $comment->setDiscussion($discussion);

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('discussion_show', [
            'categorie' => $discussion->getCategory()->getSlug(),
            'slug' => $discussion->getSlug()
        ]);
    }

    /**
     * @Route("/comment/{id}/delete", name="comment_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Comment $comment): Response
    {
        $manager = $this->getDoctrine()->getManager();

        $manager->remove($comment);
        $manager->flush();

        return $this->redirectToRoute('discussion_show', [
            'categorie' => $comment->getDiscussion()->getCategory()->getSlug(),
            'slug' => $comment->getDiscussion()->getSlug()
        ]);
    }
}
