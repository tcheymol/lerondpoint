<?php

namespace App\Domain\Search;

use App\Domain\Location\Region;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<Search> */
class SearchType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $years = array_reverse(range(2010, (int) date('Y') + 1));
        $builder
            ->add('text', TextType::class, [
                'attr' => [
                    'placeholder' => 'Search',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
            ])
            ->add('kind', EntityType::class, [
                'class' => TrackKind::class,
                'attr' => [
                    'placeholder' => 'Kind',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => [
                    'placeholder' => 'Tags',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
                'multiple' => true,
            ])
            ->add('region', EnumType::class, [
                'class' => Region::class,
                'attr' => [
                    'placeholder' => 'Region',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
            ])
            ->add('year', ChoiceType::class, [
                'attr' => [
                    'placeholder' => 'Year',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'choices' => array_combine($years, $years),
                'required' => false,
            ])
            ->add('location', TextType::class, [
                'attr' => [
                    'placeholder' => 'Location',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
            ])
        ;
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
        ]);
    }
}
