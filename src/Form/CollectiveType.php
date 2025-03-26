<?php

namespace App\Form;

use App\Entity\Action;
use App\Entity\Collective;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/** @extends AbstractType<Collective> */
class CollectiveType extends AbstractType
{
    #[\Override]
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        match ($options['step']) {
            3 => $this->buildStep3($builder),
            2 => $this->buildStep2($builder),
            default => $this->buildStep1($builder),
        };
    }

    #[\Override]
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Collective::class,
            'step' => 1,
        ]);
    }

    private function buildStep1(FormBuilderInterface $builder): void
    {
        $builder
            ->add('name', null, ['label' => 'CollectiveName'])
            ->add('iconPath', HiddenType::class)
            ->add('shortDescription', TextType::class, ['label' => 'ShortDescription'])
            ->add('followUs', TextType::class, ['label' => 'FollowUs'])
            ->add('contactUs', TextType::class, ['label' => 'ContactUs'])
            ->add('location', TextType::class, ['label' => 'Location', 'required' => false])
            ->add('description', TextareaType::class, ['label' => 'LongDescription'])
            ->add('actions', EntityType::class, [
                'class' => Action::class,
                'choice_label' => 'name',
                'choice_attr' => fn (Action $action) => [
                    'data-name' => $action->getName(),
                    'data-icon' => $action->getIconPublicPath(true),
                ],
                'query_builder' => fn (EntityRepository $er): QueryBuilder => $er->createQueryBuilder('a')->andWhere('a.disabled != TRUE'),
                'attr' => [
                    'data-controller' => 'tomselect',
                    'data-tomselect-icons-value' => 'true',
                    'data-tomselect-preview-image-id-value' => 'autocompleteIconPreviewImage',
                    'data-tomselect-url-field-id-value' => 'collective_iconPath',
                ],
                'multiple' => true,
                'required' => false,
            ]);
    }

    private function buildStep2(FormBuilderInterface $builder): void
    {
        $builder
            ->add('lat', HiddenType::class)
            ->add('lon', HiddenType::class)
            ->add('address_line1', HiddenType::class)
            ->add('address_line2', HiddenType::class)
            ->add('city', HiddenType::class)
            ->add('country', HiddenType::class)
            ->add('postcode', HiddenType::class)
            ->add('state', HiddenType::class);
    }

    private function buildStep3(FormBuilderInterface $builder): void
    {
        $builder->add('checkDisclaimerAcknowledged', CheckboxType::class, [
            'label' => 'IUnderstand',
            'mapped' => false,
            'attr' => [
                'class' => 'btn-check',
                'data-action' => 'acknowledge-checkbox#check',
            ],
            'label_attr' => ['class' => 'btn btn-outline-secondary'],
        ]);
    }
}
