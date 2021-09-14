<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Discussion;
use App\Form\DiscussionType;
use App\Repository\DiscussionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("categorie/{categorie}/discussion")
 * @ParamConverter("category", options={"mapping": {"categorie": "slug"}})
 */
class DiscussionController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/creer", name="discussion_new")
     */
    public function new(Request $request, Category $category): Response
    {
        $form = $this->createForm(DiscussionType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discussion = $form->getData();
            $discussion->setCategory($category);
            $discussion->setUser($this->getUser());

            $this->manager->persist($discussion);
            $this->manager->flush();

            return $this->redirectToRoute('categories', ['slug' => $category->getSlug()]);
        }

        return $this->renderForm('discussion/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{slug}", name="discussion_show", methods={"GET"})
     */
    public function show(Discussion $discussion): Response
    {
        return $this->render('discussion/show.html.twig', [
            'discussion' => $discussion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="discussion_edit")
     */
    public function edit(Request $request, Discussion $discussion): Response
    {
        $form = $this->createForm(DiscussionType::class, $discussion)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            return $this->redirectToRoute('discussion_index');
        }

        return $this->renderForm('discussion/edit.html.twig', [
            'discussion' => $discussion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="discussion_delete", methods={"POST"})
     */
    public function delete(Request $request, Discussion $discussion): Response
    {
        if ($this->isCsrfTokenValid('delete' . $discussion->getId(), $request->request->get('_token'))) {
            $this->manager->remove($discussion);
            $this->manager->flush();
        }

        return $this->redirectToRoute('discussion_index');
    }
}
