<?php

namespace App\Domain\Search;

use App\Entity\Collective;
use App\Entity\Region;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\Year;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<Search> */
class SearchType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextType::class, [
                'attr' => [
                    'placeholder' => 'Search',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
            ])
            ->add('kinds', EntityType::class, [
                'class' => TrackKind::class,
                'attr' => [
                    'placeholder' => 'Kind',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
                'multiple' => true,
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => [
                    'placeholder' => 'Tags',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'query_builder' => fn (EntityRepository $repository) => $repository->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC'),
                'required' => false,
                'multiple' => true,
            ])
            ->add('regions', EntityType::class, [
                'class' => Region::class,
                'attr' => [
                    'placeholder' => 'Region',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
                'multiple' => true,
            ])
            ->add('collectives', EntityType::class, [
                'class' => Collective::class,
                'attr' => [
                    'placeholder' => 'Collective',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'query_builder' => fn (EntityRepository $repository) => $repository
                    ->createQueryBuilder('t')
                    ->andWhere('t.isCreating = false')
                    ->orderBy('t.name', 'ASC'),
                'required' => false,
                'multiple' => true,
            ])
            ->add('years', EntityType::class, [
                'class' => Year::class,
                'attr' => [
                    'placeholder' => 'Year',
                    'data-controller' => 'tomselect',
                    'data-action' => 'async-search#search',
                ],
                'required' => false,
                'multiple' => true,
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
