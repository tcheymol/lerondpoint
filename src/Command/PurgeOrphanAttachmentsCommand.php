<?php

namespace App\Command;

use App\Repository\AttachmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:purge-orphan-attachments',
    description: 'Purge orphan attachments',
)]
class PurgeOrphanAttachmentsCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly AttachmentRepository $repository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Purging all attachments linked to no track');

        $attachments = $this->repository->findOrphan();

        $io->note(sprintf('%s Attachment linked to no track will be deleted, continue ?', count($attachments)));

        foreach ($attachments as $attachment) {
            $this->em->remove($attachment);
        }
        $this->em->flush();

        $io->success('Successfully deleted all orphan attachments');

        return Command::SUCCESS;
    }
}
