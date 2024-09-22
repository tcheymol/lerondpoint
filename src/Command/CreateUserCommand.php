<?php

namespace App\Command;

use App\Entity\User;
use App\Helper\PasswordHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-user',
    description: 'Add a short description for your command',
)]
class CreateUserCommand extends Command
{
    public function __construct(private readonly PasswordHelper $passwordHelper)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user')
            ->addOption(
                'admin',
                null,
                InputOption::VALUE_NONE,
                'Should I promote the user to admin?',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        if (!$email || !$password) {
            $io->error('You must provide an email and a password');
            return Command::FAILURE;
        }

        $io->note(sprintf('Creating a user: %s', $email));
        $user = (new User($email))->setPlainPassword($password);

        if ($input->getOption('admin')) {
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
