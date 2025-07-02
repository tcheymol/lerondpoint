<?php

namespace App\Form;

use App\Entity\RejectionCause;
use App\Form\Model\RejectTrack;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RejectTrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rejectionCause', EntityType::class, [
                'class' => RejectionCause::class,
                'choice_label' => 'name',
                'label' => 'RejectionCause',
                'attr' => ['placeholder' => 'RejectionCause'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RejectTrack::class,
        ]);
    }
}
