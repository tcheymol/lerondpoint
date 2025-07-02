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
        yield FormField::addColumn(8);
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield NumberField::new('lat');
        yield NumberField::new('lon');

        yield TextField::new('addressLine1');
        yield TextField::new('addressLine2');
        yield TextField::new('postcode');
        yield TextField::new('city');
        yield TextField::new('country');
        yield TextField::new('state');

        yield CollectionField::new('actions')->hideOnForm();
        yield CollectionField::new('tracks')->hideOnForm();

        yield FormField::addColumn(4);
        yield BooleanField::new('validated');
        yield BooleanField::new('isCreating');
        yield AssociationField::new('owner');
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
        yield DateField::new('deletedAt')->hideOnForm();
        yield DateField::new('disabledAt')->hideOnForm();
        yield AssociationField::new('createdBy')->hideOnForm();
        yield AssociationField::new('updatedBy')->hideOnForm();
        yield AssociationField::new('disabledBy')->hideOnForm();
        yield AssociationField::new('deletedBy')->hideOnForm();
        yield AssociationField::new('validatedBy')->hideOnForm();
    }
}
