<?php

namespace App\Form;

use App\Domain\Location\Region;
use App\Domain\Security\UserAwareTrait;
use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrackType extends AbstractType
{
    use UserAwareTrait;

    public function __construct(private readonly Security $security)
    {
    }

    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = array_reverse(range(2010, (int) date('Y') + 1));
        $builder
            ->add('name')
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => ['data-controller' => 'tomselect'],
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('region', EnumType::class, [
                'class' => Region::class,
                'attr' => ['data-controller' => 'tomselect'],
            ])
            ->add('description', TextAreaType::class, [
                'attr' => ['rows' => 5],
            ])
            ->add('location')
            ->add('year', ChoiceType::class, [
                'choices' => array_combine($years, $years),
            ])
            ->add('attachmentsIds', HiddenType::class)
        ;

        $builder->get('attachmentsIds')->addModelTransformer(new CallbackTransformer(
            fn ($tagsAsArray) => implode(',', $tagsAsArray),
            fn ($tagsAsString) => explode(',', (string) $tagsAsString)
        ));

        $user = $this->getUser();
        if ($user && $user->hasCollective()) {
            $builder->add('collective', EntityType::class, [
                'class' => Collective::class,
                'attr' => ['data-controller' => 'tomselect'],
                'label_attr' => ['class' => 'col-sm-12'],
                'choice_label' => 'name',
                'required' => false,
                'data' => $user->getFirstCollective(),
            ]);
        }
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}
