<?php

namespace App\Controller\Admin;

use App\Entity\CategoryGroup;
use App\Form\CategoryGroupType;
use App\Repository\CategoryGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie/groupe")
 */
class CategoryGroupController extends AbstractController
{
    /**
     * @Route("/", name="category_group_index")
     */
    public function index(CategoryGroupRepository $categoryGroupRepository): Response
    {
        return $this->render('admin/category_group/index.html.twig', [
            'category_groups' => $categoryGroupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/creer", name="category_group_new")
     */
    public function new(Request $request): Response
    {
        $categoryGroup = new CategoryGroup();
        $form = $this->createForm(CategoryGroupType::class, $categoryGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryGroup);
            $entityManager->flush();

            return $this->redirectToRoute('category_group_index');
        }

        return $this->renderForm('admin/category_group/new.html.twig', [
            'category_group' => $categoryGroup,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_group_show", methods={"GET"})
     */
    public function show(CategoryGroup $categoryGroup): Response
    {
        return $this->render('admin/category_group/show.html.twig', [
            'category_group' => $categoryGroup,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="category_group_edit")
     */
    public function edit(Request $request, CategoryGroup $categoryGroup): Response
    {
        $form = $this->createForm(CategoryGroupType::class, $categoryGroup)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_group_index');
        }

        return $this->renderForm('admin/category_group/edit.html.twig', [
            'category_group' => $categoryGroup,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="category_group_delete", methods={"POST"})
     */
    public function delete(Request $request, CategoryGroup $categoryGroup): Response
    {
        if ($this->isCsrfTokenValid('delete' . $categoryGroup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryGroup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_group_index');
    }
}
