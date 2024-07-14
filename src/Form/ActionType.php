<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\ActionKind;
use App\Entity\ActionTag;
use App\Entity\Collective;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('coordinatesX')
            ->add('coordinatesY')
            ->add('notes')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('disabled')
            ->add('validated')
            ->add('kind', EntityType::class, [
                'class' => ActionKind::class,
                'choice_label' => 'id',
            ])
            ->add('tags', EntityType::class, [
                'class' => ActionTag::class,
                'choice_label' => 'id',
            ])
            ->add('collective', EntityType::class, [
                'class' => Collective::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Action::class,
        ]);
    }
}
