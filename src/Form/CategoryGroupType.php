<?php

namespace App\Form;

use App\Entity\CategoryGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du groupe de catégorie',
                'row_attr' => [
                    'class' => 'form_row'
                ],
                'attr' => [
                    'class' => 'form_input',
                    'placeholder' => 'Veuillez saisir le nom du groupe de catégorie'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategoryGroup::class,
        ]);
    }
}
