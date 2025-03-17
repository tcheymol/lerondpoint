<?php

namespace App\Controller\Admin;

use App\Entity\Invitation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class InvitationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Invitation::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        return [
            yield DateTimeField::new('date'),
            yield AssociationField::new('collective'),
            yield AssociationField::new('user'),
            yield AssociationField::new('invitedBy'),
        ];
    }
}
