<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('plainPassword')->onlyOnForms(),
            ChoiceField::new('roles', 'roles')->setChoices(User::ROLES)->allowMultipleChoices(),
            BooleanField::new('disabled'),
            BooleanField::new('validated'),
        ];
    }

    #[\Override]
    /** @param User $entityInstance */
    public function persistEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        $this->updatePassword($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    #[\Override]
    /** @param User $entityInstance */
    public function updateEntity(EntityManagerInterface $entityManager, mixed $entityInstance): void
    {
        $this->updatePassword($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    /** @param User $entityInstance */
    public function updatePassword(mixed $entityInstance): void
    {
        if ($entityInstance->getPlainPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPlainPassword());
            $entityInstance->setPassword($hashedPassword);
        }
    }
}
