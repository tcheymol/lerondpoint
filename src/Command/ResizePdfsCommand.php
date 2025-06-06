<?php

namespace App\Command;

use App\Repository\AttachmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:resize-pdfs',
    description: 'Reset the sizes of the existing pdf attachments to A4',
)]
readonly class ResizePdfsCommand
{
    public function __construct(
        private AttachmentRepository $repository,
        private EntityManagerInterface $em,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Resetting all pdfs attachments size');

        $pdfAttachments = $this->repository->findBy(['kind' => 'application/pdf']);

        $io->note(sprintf('Found %d attachments', count($pdfAttachments)));

        foreach ($pdfAttachments as $attachment) {
            $attachment->setWidth('595')->setHeight('842');
        }
        $this->em->flush();

        $io->success('Done');

        return Command::SUCCESS;
    }
}
