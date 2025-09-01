<?php

namespace App\Form;

use App\Domain\Security\UserAwareTrait;
use App\Entity\Collective;
use App\Entity\Region;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\Year;
use Doctrine\ORM\EntityRepository;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
    public const array steps = [1, 2, 3, 4];
    public const int STEPS_COUNT = 4;
    public const array STEPS = [
        1 => 'AddFiles',
        2 => 'MainInformations',
        3 => 'Description',
        4 => 'PreviewTrack',
    ];

    public function __construct(private readonly Security $security)
    {
    }

    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var int $step */
        $step = $options['step'];
        if (1 === $step) {
            $this->buildStep1($builder, $options);
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

    /** @param array<string, mixed> $options */
    private function buildStep1(FormBuilderInterface $builder, array $options): void
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
            ->add('attachmentsIds', HiddenType::class);

        $track = $options['data'] ?? null;
        if (!($track instanceof Track && $track->getId())) {
            $builder->add('captcha', CaptchaType::class, [
                'expiration' => 300,
                'reload' => true,
                'as_url' => true,
                'width' => 200,
                'height' => 100,
                'length' => 4,
                'attr' => ['placeholder' => 'Captcha', 'class' => 'mt-2'],
            ]);
        }

        $builder->get('attachmentsIds')->addModelTransformer(new CallbackTransformer(
            fn ($tagsAsArray) => implode(',', $tagsAsArray),
            fn ($tagsAsString) => explode(',', (string) $tagsAsString)
        ));
    }

    private function buildStep2(FormBuilderInterface $builder): void
    {
        /** @var Track $data */
        $data = $builder->getData();
        $builder
            ->add('kind', EntityType::class, [
                'class' => TrackKind::class,
                'attr' => [
                    'data-controller' => 'tomselect',
                    'placeholder' => 'CategoryRequired',
                    'data-action' => 'autosubmit#submit',
                ],
                'placeholder' => 'CategoryRequired',
                'choice_label' => 'name',
            ])
            ->add('tags', EntityType::class, [
                'class' => TrackTag::class,
                'attr' => [
                    'data-controller' => 'tomselect',
                    'placeholder' => 'Tags',
                    'data-action' => 'autosubmit#submit',
                ],
                'query_builder' => fn (EntityRepository $repository) => $repository->createQueryBuilder('t')
                    ->orderBy('t.name', 'ASC'),
                'required' => false,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('location', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Location',
                    'data-action' => 'autosubmit#submit',
                ],
            ])
            ->add('regions', EntityType::class, [
                'class' => Region::class,
                'attr' => [
                    'data-controller' => 'tomselect',
                    'placeholder' => 'Regions',
                    'data-action' => 'autosubmit#submit',
                ],
                'required' => false,
                'multiple' => true,
                'choice_label' => 'name',
            ])
            ->add('years', EntityType::class, [
                'class' => Year::class,
                'attr' => [
                    'data-controller' => 'tomselect',
                    'placeholder' => 'Years',
                    'data-action' => 'autosubmit#submit',
                ],
                'required' => false,
                'multiple' => true,
                'choice_label' => 'value',
            ])
            ->add('hasFaces', ChoiceType::class, [
                'label' => 'HasFaces',
                'attr' => [
                    'data-action' => 'autosubmit#submit',
                ],
                'choices' => ['Yes' => true, 'No' => false],
                'choice_attr' => fn ($choice, string $key, mixed $value) => ['data-action' => 'checkbox#toggle'],
                'expanded' => true,
                'data' => $data->hasFaces() ?? false,
            ])
            ->add('iAppliedRecommendations', CheckboxType::class, [
                'label' => 'IAppliedRecommendations',
                'attr' => [
                    'data-action' => 'autosubmit#submit',
                ],
                'label_attr' => ['class' => 'grotesk'],
                'mapped' => false,
                'data' => true,
            ])
            ->add('collective', EntityType::class, [
                'class' => Collective::class,
                'query_builder' => fn (EntityRepository $repository) => $repository->createQueryBuilder('c')
                        ->andWhere('c.disabled = FALSE'),
                'attr' => [
                    'data-controller' => 'tomselect',
                    'placeholder' => 'Collective',
                    'data-action' => 'autosubmit#submit',
                ],
                'choice_label' => 'name',
                'required' => false,
            ]);
    }

    private function buildStep3(FormBuilderInterface $builder): void
    {
        $builder
            ->add('description', TextareaType::class, [
                'label' => 'TellUsTheHistoryOfYourTrack',
                'required' => false,
                'attr' => ['rows' => 5, 'data-action' => 'autosubmit#submit'],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Email', 'data-action' => 'autosubmit#submit',],
            ]);
    }

    private function buildButtons(FormBuilderInterface $builder, int $step): void
    {
        $buttonClasses = 'btn hoverable-light btn-lg mt-3';
        $nextButtonClasses = ' btn-light bg-white ';
        $nextStep = $step + 1;

        $builder
            ->add('next', SubmitType::class, [
                'label' => $step >= self::STEPS_COUNT ? 'ValidateAndSend' : 'ValidateStep',
                'label_translation_parameters' => ['%step%' => $nextStep, '%total%' => self::STEPS_COUNT],
                'attr' => [
                    'class' => $buttonClasses.$nextButtonClasses,
                    'tabindex' => 0,
                ],
            ]);
    }
}
