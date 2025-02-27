<?php

namespace App\Command;

use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:purge-creating-collectives',
    description: 'Add collective not created',
)]
class PurgeCreatingTracksCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly TrackRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Purging all tracks being created');

        $tracks = $this->repository->findBy(['isDraft' => true]);

        $io->note(sprintf('%s tracks will be deleted, continue ?', count($tracks)));

        foreach ($tracks as $track) {
            $this->em->remove($track);
        }
        $this->em->flush();

        $io->success('Successfully deleted all tracks being created');

        return Command::SUCCESS;
    }
}
