<?php

namespace App\Controller\Admin;

use App\Entity\Collective;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CollectiveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Collective::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            BooleanField::new('disabled'),
            BooleanField::new('validated'),
            AssociationField::new('owner')->hideOnForm(),
            DateField::new('createdAt')->hideOnForm(),
            DateField::new('updatedAt')->hideOnForm(),
            DateField::new('deletedAt')->hideOnForm(),
            DateField::new('disabledAt')->hideOnForm(),

            AssociationField::new('createdBy')->hideOnForm(),
            AssociationField::new('updatedBy')->hideOnForm(),
            AssociationField::new('disabledBy')->hideOnForm(),
            AssociationField::new('deletedBy')->hideOnForm(),
            AssociationField::new('validatedBy')->hideOnForm(),

            NumberField::new('lat'),
            NumberField::new('lng'),

            CollectionField::new('actions')->hideOnForm(),
            CollectionField::new('tracks')->hideOnForm(),
        ];
    }
}
