<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Producto;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nombre')
            ->add('Descripcion')
            ->add('Peso')
            ->add('Precio')
            ->add('Stock')
            ->add('Imagen', FileType::class, [
                'label' => 'Imagen del producto',
                'mapped' => false,
                'required' => false,
            ])
            ->add('Categoria', EntityType::class, [
                'class' => Categoria::class,
'choice_label' => 'nombre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Producto::class,
        ]);
    }
}
