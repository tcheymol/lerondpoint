<?php

namespace App\Form;

use App\Entity\NewsletterRegistration;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterRegistrationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('captcha', CaptchaType::class, [
                'expiration' => 300,
                'reload' => true,
                'as_url' => true,
                'width' => 100,
                'height' => 50,
                'length' => 4,
                'attr' => ['placeholder' => 'Captcha', 'class' => 'mt-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewsletterRegistration::class,
        ]);
    }
}
