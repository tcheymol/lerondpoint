<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AttachmentCrudController extends AbstractCrudController
{
    #[\Override]
    public static function getEntityFqcn(): string
    {
        return Attachment::class;
    }
}
