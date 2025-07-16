<?php

namespace App\Form;

use App\Entity\User;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('username', TextType::class, ['required' => false, 'label' => 'UsernameLabel'])
            ->add('plainPassword', RepeatedPasswordType::class, ['required' => $options['isCreating']]);

        if ($options['isCreating']) {
            $builder->add('captcha', CaptchaType::class, [
                'expiration' => 300,
                'reload' => true,
                'as_url' => true,
                'width' => 100,
                'height' => 50,
                'length' => 4,
                'attr' => ['placeholder' => 'Captcha', 'class' => 'mt-2'],
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isCreating' => false,
        ]);
    }
}
