<?php

namespace App\Form;

use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('disabled')
            ->add('validated')
            ->add('collective', EntityType::class, [
                'class' => Collective::class,
                'choice_label' => 'id',
            ])
            ->add('kind', EntityType::class, [
                'class' => TrackKind::class,
                'choice_label' => 'id',
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
