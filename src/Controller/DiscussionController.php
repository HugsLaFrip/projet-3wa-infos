<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Discussion;
use App\Form\CommentType;
use App\Form\DiscussionType;
use App\Repository\DiscussionRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
     * @ParamConverter("discussion", options={"mapping": {"slug": "slug"}})
     */
    public function show(Request $request, Discussion $discussion): Response
    {
        // $form = $this->createForm(CommentType::class)->handleRequest($request);
        $form = $this->createFormBuilder(null, ['data_class' => Comment::class])
            ->setAction($this->generateUrl('discussion_show', [
                'categorie' => $discussion->getCategory()->getSlug(),
                'slug' => $discussion->getSlug()
            ]))
            ->add('content', CKEditorType::class, [
                'label' => false,
                'row_attr' => ['class' => 'form_row'],
                'attr' => ['class' => 'form_input']
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();

            $comment->setUser($this->getUser());
            $comment->setDiscussion($discussion);

            $this->manager->persist($comment);
            $this->manager->flush();

            return $this->redirectToRoute('discussion_show', ['categorie' => $discussion->getCategory()->getSlug(), 'slug' => $discussion->getSlug()]);
        }

        return $this->render('discussion/show.html.twig', [
            'discussion' => $discussion,
            'form' => $form->createView()
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
