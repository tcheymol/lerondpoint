<?php

namespace App\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected function isButtonClicked(FormInterface $form, string $formName): bool
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

    protected function backHome(): RedirectResponse
    {
        return $this->redirectToRoute('home');
    }
}
