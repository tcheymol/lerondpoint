<?php

namespace App\Command;

use App\Repository\CollectiveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:purge-creating-collectives',
    description: 'Add collective not created',
)]
readonly class PurgeCreatingCollectivesCommand
{
    public function __construct(private EntityManagerInterface $em, private CollectiveRepository $repository)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Purging all collective being created');
        $this->removeCollectives($io);
        $io->success('Successfully deleted all collective being created');

        return Command::SUCCESS;
    }

    public function removeCollectives(SymfonyStyle $io): void
    {
        $collectives = $this->repository->findBy(['isCreating' => true]);

        $io->note(sprintf('%s Collective will be deleted', count($collectives)));

        foreach ($collectives as $collective) {
            $this->em->remove($collective);
        }
        $this->em->flush();
    }
}
