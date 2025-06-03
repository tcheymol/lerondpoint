<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:validate-user',
    description: 'Add a short description for your command',
)]
readonly class ValidateUserCommand
{
    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $em)
    {
    }

    public function __invoke(SymfonyStyle $io, #[Argument] string $email, #[Option] bool $activate = false): int
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            $io->error(sprintf('User with email %s not found', $email));

            return Command::FAILURE;
        }

        if ($user->isValidatedEmail()) {
            $io->warning(sprintf('User with email %s is already validated', $email));

            return Command::SUCCESS;
        }

        $user->validateEmail();
        $this->em->flush();

        $io->success(sprintf('User with email %s has been validated', $email));

        return Command::SUCCESS;
    }
}
