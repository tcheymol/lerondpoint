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
use Symfony\UX\Dropzone\Form\DropzoneType;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('collective', EntityType::class, [
                'class' => Collective::class,
                'attr' => ['data-controller' => 'tomselect'],
                'choice_label' => 'name',
            ])
            ->add('kind', EntityType::class, [
                'class' => TrackKind::class,
                'attr' => ['data-controller' => 'tomselect'],
                'choice_label' => 'name',
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => ['data-controller' => 'tomselect'],
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('uploadedFile', DropzoneType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
