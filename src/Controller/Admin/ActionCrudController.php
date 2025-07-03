<?php

namespace App\Controller\Admin;

use App\Entity\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActionCrudController extends AbstractCrudController
{
    #[\Override]
    public static function getEntityFqcn(): string
    {
        return Action::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('name');
        yield DateField::new('createdAt')->hideOnForm();
        yield ImageField::new('iconPublicPath')->setLabel('Icon')->hideOnForm();
    }
}
