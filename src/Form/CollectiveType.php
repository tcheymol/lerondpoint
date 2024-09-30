<?php

namespace App\Form;

use App\Entity\Collective;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name')
            ->add('lat', HiddenType::class)
            ->add('lon', HiddenType::class)
            ->add('address_line1', HiddenType::class)
            ->add('address_line2', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('country', HiddenType::class)
            ->add('postcode', HiddenType::class)
            ->add('state', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collective::class,
        ]);
    }
}
