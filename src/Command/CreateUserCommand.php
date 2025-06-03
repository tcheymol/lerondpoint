<?php

namespace App\Command;

use App\Entity\User;
use App\Helper\PasswordHelper;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
readonly class CreateUserCommand
{
    public function __construct(private PasswordHelper $passwordHelper)
    {
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument] string $email,
        #[Argument] string $password,
        #[Option] bool $admin = false,
    ): int {
        $io->note(sprintf('Creating a user: %s', $email));
        $user = new User($email)->setPlainPassword($password);

        if ($admin) {
            $io->note('Promoting the user to admin');
            $user->addRole('ROLE_ADMIN');
        }

        $this->passwordHelper->updateUserPasswordWithPlain($user);

        $io->success('User created');
        if ($user->hasRole('ROLE_ADMIN')) {
            $io->note('User is now an admin');
        }

        return Command::SUCCESS;
    }
}
