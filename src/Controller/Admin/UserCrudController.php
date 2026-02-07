<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    #[\Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    #[\Override]
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield EmailField::new('email');
        yield TextField::new('username');
        yield TextField::new('plainPassword')->onlyOnForms();
        yield ChoiceField::new('roles', 'roles')->setChoices(User::ROLES)->allowMultipleChoices();
        yield BooleanField::new('disabled');
        yield BooleanField::new('validatedEmail')->setLabel('EmailValidated');
        yield BooleanField::new('hasAcceptedTerms')->onlyOnForms();
        yield BooleanField::new('hasAcceptedNewsletter')->setLabel('Newsletter');
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updatedAt')->onlyOnDetail();
    }

    #[\Override]
    public function persistEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }
        $entityInstance->validateEmail();
        $this->updatePassword($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    #[\Override]
    public function updateEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }
        $this->updatePassword($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function updatePassword(mixed $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }
        if ($entityInstance->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPlainPassword());
            $entityInstance->setPassword($hashedPassword);
        }
    }
}
