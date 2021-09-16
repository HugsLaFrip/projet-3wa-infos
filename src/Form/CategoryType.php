<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la catégorie',
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Veuillez saisir le nom de la catégorie'
                ]
            ])
            ->add('categoryGroup', EntityType::class, [
                'label' => 'Groupe de catégorie',
                'class' => CategoryGroup::class,
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
