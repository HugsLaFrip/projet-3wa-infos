<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'row_attr' => [
                    'class' => 'form_row',
                ],
                'attr' => [
                    'placeholder' => 'exemple@mail.com',
                    'class' => 'form_input',
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Veuillez saisir un mot de passe'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
