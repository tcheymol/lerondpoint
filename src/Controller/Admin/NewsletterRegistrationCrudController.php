<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterRegistration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewsletterRegistrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsletterRegistration::class;
    }
}
