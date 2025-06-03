<?php

namespace App\Command;

use App\Repository\AttachmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:purge-orphan-attachments',
    description: 'Purge orphan attachments',
)]
readonly class PurgeOrphanAttachmentsCommand
{
    public function __construct(private EntityManagerInterface $em, private AttachmentRepository $repository)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Purging all attachments linked to no track');
        $this->removeAttachments($io);
        $io->success('Successfully deleted all orphan attachments');

        return Command::SUCCESS;
    }

    public function removeAttachments(SymfonyStyle $io): void
    {
        $attachments = $this->repository->findOrphan();

        $io->note(sprintf('%s Attachment linked to no track will be deleted, continue ?', count($attachments)));

        foreach ($attachments as $attachment) {
            $this->em->remove($attachment);
        }
        $this->em->flush();
    }
}
