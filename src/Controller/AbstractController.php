<?php

namespace App\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function isButtonClicked(FormInterface $form, string $formName): bool
    {
        if (!$form instanceof Form) {
            return false;
        }

        $button = $form->getClickedButton();
        if (!$button instanceof FormInterface) {
            return false;
        }

        return $button->getName() === $formName;
    }
}
