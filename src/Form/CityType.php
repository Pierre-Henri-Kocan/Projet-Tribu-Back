<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la ville',
                ])
            ->add('image')
            ->add('country', TextType::class, [
                'label' => 'Nom du pays',
                ])
            ->add('slug', TextType::class, [
                'label' => 'nom-de-la-ville-sluggifié',
                ])
            ->add('description', TextType::class, [
                'label' => 'Description de la ville',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
