<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte/{pseudo}", name="account")
     */
    public function index(User $user): Response
    {
        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/compte/{pseudo}/modifier", name="account_edit")
     */
    public function edit(Request $request): Response
    {
        $form = $this->createForm(AccountType::class, $this->getUser())->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('_avatar')->getData();

            // Handle the file
            if ($avatar) {
                $originalName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);

                $fileName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $originalName), '-')) . '-' . uniqid() . '.' . $avatar->guessExtension();

                $avatar->move($this->getParameter('files'), $fileName);

                $form->getData()->setAvatar($fileName);
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Compte modifié avec succès');

            return $this->redirectToRoute('account', [
                'pseudo' => $this->getUser()->getPseudo()
            ]);
        }

        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
