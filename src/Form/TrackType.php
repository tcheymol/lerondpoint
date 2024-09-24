<?php

namespace App\Form;

use App\Domain\Security\UserAwareTrait;
use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class TrackType extends AbstractType
{
    use UserAwareTrait;
    public function __construct(private readonly Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
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
                'required' => false,
            ])
            ->add('uploadedFile', DropzoneType::class, [
                'attr' => [
                    'data-controller' => 'dropzone',
                    'placeholder' => 'Recherchez ou déposez votre fichier ici',
                ],
            ])
        ;
        $user = $this->getUser();
        if ($user && $user->hasMultipleCollectives()) {
            $builder->add('collective', EntityType::class, [
                'class' => Collective::class,
                'attr' => ['data-controller' => 'tomselect'],
                'choice_label' => 'name',
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
