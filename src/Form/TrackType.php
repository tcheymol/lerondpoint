<?php

namespace App\Form;

use App\Domain\Location\Region;
use App\Domain\Security\UserAwareTrait;
use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<Track> */
class TrackType extends AbstractType
{
    use UserAwareTrait;

    /** @var int[] */
    public const array steps = [1, 2, 3];
    public const int stepsCount = 3;

    public function __construct(private readonly Security $security)
    {
    }

    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var int $step */
        $step = $options['step'];
        if (1 === $step) {
            $this->buildStep1($builder);
        } elseif (2 === $step) {
            $this->buildStep2($builder);
        } elseif (3 === $step) {
            $this->buildStep3($builder);
        }
        $this->buildButtons($builder, $step);
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
            'step' => 1,
        ]);
    }

    private function buildStep1(FormBuilderInterface $builder): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'TrackTitle',
                'attr' => ['autofocus' => true, 'placeholder' => 'TrackTitle'],
            ])
            ->add('url', TextType::class, [
                'label' => 'EnterUrl',
                'required' => false,
                'attr' => ['placeholder' => 'https://example.com'],
            ])
            ->add('attachmentsIds', HiddenType::class)
//            ->add('captcha', CaptchaType::class, [
//                'attr' => ['placeholder' => 'Captcha', 'class' => 'mt-2'],
//            ])
        ;

        $builder->get('attachmentsIds')->addModelTransformer(new CallbackTransformer(
            fn ($tagsAsArray) => implode(',', $tagsAsArray),
            fn ($tagsAsString) => explode(',', (string) $tagsAsString)
        ));
    }

    private function buildStep2(FormBuilderInterface $builder): void
    {
        $years = array_reverse(range(2018, (int) date('Y')));
        $builder
            ->add('kind', EntityType::class, [
                'class' => TrackKind::class,
                'attr' => ['data-controller' => 'tomselect', 'placeholder' => 'Category'],
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => ['data-controller' => 'tomselect', 'placeholder' => 'Tags'],
                'query_builder' => fn (EntityRepository $repository) => $repository->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC'),
                'required' => false,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('region', EnumType::class, [
                'class' => Region::class,
                'required' => false,
                'attr' => ['data-controller' => 'tomselect', 'placeholder' => 'Region'],
            ])
            ->add('hasFaces', ChoiceType::class, [
                'label' => 'HasFaces',
                'choices' => ['Yes' => true, 'No' => false],
                'choice_attr' => fn ($choice, string $key, mixed $value) => ['data-action' => 'checkbox#toggle'],
                'expanded' => true,
                'data' => false,
            ])
            ->add('iAppliedRecommendations', CheckboxType::class, [
                'label' => 'IAppliedRecommendations',
                'label_attr' => ['class' => 'grotesk'],
                'mapped' => false,
            ])
            ->add('location', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Location'],
            ])
            ->add('year', ChoiceType::class, [
                'choices' => array_combine($years, $years),
                'required' => false,
                'attr' => ['data-controller' => 'tomselect', 'placeholder' => 'Year'],
            ]);

        $user = $this->getUser();
        if ($user && $user->hasCollective()) {
            $builder->add('collective', EntityType::class, [
                'class' => Collective::class,
                'attr' => ['data-controller' => 'tomselect', 'placeholder' => 'Location'],
                'choice_label' => 'name',
                'required' => false,
                'data' => $user->getFirstCollective(),
            ]);
        }
    }

    private function buildStep3(FormBuilderInterface $builder): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => ['rows' => 5],
            ]);
    }

    private function buildButtons(FormBuilderInterface $builder, int $step): void
    {
        $buttonClasses = 'btn btn-light bg-white hoverable-light btn-lg mt-3';
        if ($step > 1) {
            $previousStep = $step - 1;
            $builder->add('back', SubmitType::class, [
                'label' => 'BackStep',
                'label_translation_parameters' => ['%step%' => $previousStep, '%total%' => self::stepsCount],
                'attr' => ['class' => $buttonClasses],
            ]);
        }
        $builder->add('next', SubmitType::class, [
            'label' => 'ValidateStep',
            'label_translation_parameters' => ['%step%' => $step, '%total%' => self::stepsCount],
            'attr' => [
                'class' => sprintf('%s %s', $buttonClasses, $step > 1 ? '' : ' disabled '),
            ],
        ]);
    }
}
