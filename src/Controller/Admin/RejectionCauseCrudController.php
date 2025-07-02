<?php

namespace App\Controller\Admin;

use App\Entity\RejectionCause;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RejectionCauseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RejectionCause::class;
    }
}
