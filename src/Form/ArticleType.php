<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Titre de l\'article'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Contenu de l\'article',
                    'rows' => 15
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Sélectionnez une image',
                'required' => false,
                'download_uri' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
