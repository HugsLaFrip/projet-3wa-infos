<?php

namespace App\Controller\Security;

use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/creer-un-compte", name="security_register")
     */
    public function index(Request $request,  EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(RegisterType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($form->getData());

            $manager->flush();

            $this->addFlash('success', 'Votre compte a été crée avec succès');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
            'button_label' => 'Créer son compte'
        ]);
    }
}
