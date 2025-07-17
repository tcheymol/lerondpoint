<?php

namespace App\Command;

use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Scheduler\Attribute\AsCronTask;

#[AsCommand(
    name: 'app:purge-creating-tracks',
    description: 'Add tracks not created',
)]
#[AsCronTask('# # * * #')] // Runs every Sunday at a random time
readonly class PurgeCreatingTracksCommand
{
    public function __construct(private EntityManagerInterface $em, private TrackRepository $repository)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Purging all tracks being created');
        $this->removeTracks($io);
        $io->success('Successfully deleted all tracks being created');

        return Command::SUCCESS;
    }

    public function removeTracks(SymfonyStyle $io): void
    {
        $tracks = $this->repository->findBy(['isDraft' => true]);

        $io->note(sprintf('%s tracks will be deleted, continue ?', count($tracks)));

        foreach ($tracks as $track) {
            $this->em->remove($track);
        }
        $this->em->flush();
    }
}
