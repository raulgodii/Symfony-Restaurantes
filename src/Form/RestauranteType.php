<?php

namespace App\Form;

use App\Entity\Restaurante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestauranteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('email')
            ->add('password')
            ->add('roles')
            ->add('CP')
            ->add('Pais')
            ->add('Direccion')
            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurante::class,
        ]);
    }
}
