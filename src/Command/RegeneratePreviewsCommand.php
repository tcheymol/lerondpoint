<?php

namespace App\Command;

use App\Domain\Images\AttachmentHelper;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:regenerate-previews',
    description: 'Add a short description for your command',
)]
class RegeneratePreviewsCommand extends Command
{
    public function __construct(
        private readonly TrackRepository $repository,
        private readonly EntityManagerInterface $em,
        private readonly AttachmentHelper $attachmentHelper,
    ) {
        parent::__construct();
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('Generating previews');

        $io->note(sprintf('%s notes in db', $this->repository->count()));
        $tracks = $this->repository->findMissingPreviews();
        $io->note(sprintf('%s notes missing at least one preview', count($tracks)));

        foreach ($tracks as $track) {
            foreach ($track->getAttachments() as $attachment) {
                try {
                    $this->attachmentHelper->uploadMissingThumbnails($attachment);
                } catch (\Exception $e) {
                    $io->error(sprintf('Exception uploading thumbnail, error: %s', $e->getMessage()));
                }
            }
        }
        $this->em->flush();

        $io->success('Done');

        return Command::SUCCESS;
    }
}
