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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CollectiveCrudController extends AbstractCrudController
{
    #[\Override]
    public static function getEntityFqcn(): string
    {
        return Collective::class;
    }

    #[\Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addColumn(8),
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            NumberField::new('lat'),
            NumberField::new('lon'),

            TextField::new('addressLine1'),
            TextField::new('addressLine2'),
            TextField::new('postcode'),
            TextField::new('city'),
            TextField::new('country'),
            TextField::new('state'),

            CollectionField::new('actions')->hideOnForm(),
            CollectionField::new('tracks')->hideOnForm(),

            FormField::addColumn(4),
            BooleanField::new('disabled'),
            BooleanField::new('validated'),
            AssociationField::new('owner'),
            DateField::new('createdAt')->hideOnForm(),
            DateField::new('updatedAt')->hideOnForm(),
            DateField::new('deletedAt')->hideOnForm(),
            DateField::new('disabledAt')->hideOnForm(),
            AssociationField::new('createdBy')->hideOnForm(),
            AssociationField::new('updatedBy')->hideOnForm(),
            AssociationField::new('disabledBy')->hideOnForm(),
            AssociationField::new('deletedBy')->hideOnForm(),
            AssociationField::new('validatedBy')->hideOnForm(),
        ];
    }
}
