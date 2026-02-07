<?php

namespace App\Form;

use App\Validator\PasswordStrength;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class RepeatedPasswordType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'type' => PasswordType::class,
            'label' => false,
            'options' => [
                'attr' => ['autocomplete' => 'NewPassword'],
            ],
            'first_options' => [
                'row_attr' => ['class' => 'col-12'],
                'attr' => [
                    'data-controller' => 'password-strength',
                    'data-action' => 'password-strength#update',
                ],
                'constraints' => [
                    new Length(
                        min: 8,
                        max: 4096,
                        minMessage: 'Veuillez entrer au moins {{ limit }} caractères',
                    ),
                    new PasswordStrength(),
                    new NotCompromisedPassword(),
                ],
                'label' => 'NewPassword',
            ],
            'second_options' => [
                'label' => 'RepeatPassword',
            ],
            'invalid_message' => 'PasswordFieldsMismatch',
        ]);
    }

    #[\Override]
    public function getParent(): string
    {
        return RepeatedType::class;
    }
}
