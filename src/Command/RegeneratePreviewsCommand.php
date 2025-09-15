<?php

namespace App\Command;

use App\Domain\Track\TrackAttachmentHelper;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:regenerate-previews',
    description: 'Add a short description for your command',
)]
readonly class RegeneratePreviewsCommand
{
    public function __construct(
        private TrackRepository $repository,
        private EntityManagerInterface $em,
        private TrackAttachmentHelper $helper,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Generating previews');
        $io->note(sprintf('%s notes in db', $this->repository->count()));

        $this->regeneratePreviews($io);

        $io->success('Done');

        return Command::SUCCESS;
    }

    public function regeneratePreviews(SymfonyStyle $io): void
    {
        $tracks = $this->repository->findMissingPreviews();
        $io->note(sprintf('%s notes missing at least one preview', count($tracks)));

        foreach ($tracks as $track) {
            $this->helper->uploadMissingThumbnails($track);
        }
        $this->em->flush();
    }
}
