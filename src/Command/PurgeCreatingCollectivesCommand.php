<?php

namespace App\Command;

use App\Repository\CollectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:purge-creating-collectives',
    description: 'Add a short description for your command',
)]
class PurgeCreatingCollectivesCommand extends Command
{
    public function __construct(private EntityManagerInterface $em, private CollectiveRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Purging all collective being created');

        $collectives = $this->repository->findBy(['isCreating' => true]);

        $io->note(sprintf('%s Collective will be deleted, continue ?', count($collectives)));

        foreach ($collectives as $collective) {
            $this->em->remove($collective);
        }
        $this->em->flush();

        $io->success('Successfully deleted all collective being created');

        return Command::SUCCESS;
    }
}
