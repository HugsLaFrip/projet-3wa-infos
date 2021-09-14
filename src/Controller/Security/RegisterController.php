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

            $account = $form->getData();
            $avatar = $form->get('_avatar')->getData();

            if ($avatar) {
                $originalName = pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME);

                $fileName = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $originalName), '-')) . '-' . uniqid() . '.' . $avatar->guessExtension();

                $avatar->move($this->getParameter('files'), $fileName);

                $account->setAvatar($fileName);
            }

            $manager->persist($account);

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
