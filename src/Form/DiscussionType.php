<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Discussion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscussionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'row_attr' => ['class' => 'form_row'],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Saisissez le titre de la discussion'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'row_attr' => ['class' => 'form_row'],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Contenu de votre discussion'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discussion::class,
        ]);
    }
}
