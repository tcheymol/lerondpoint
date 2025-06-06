<?php

namespace App\Command;

use App\Entity\Attachment;
use App\Entity\Track;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-video-attachments',
    description: 'Create a video attachments for video tracks that have no attachments yet',
)]
readonly class CreateVideoAttachmentsCommand
{
    public function __construct(
        private TrackRepository $repository,
        private EntityManagerInterface $em,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $io->note('Creating attachments');

        /** @var Track[] $videoTracks */
        $videoTracks = $this->repository
            ->createQueryBuilder('t')
            ->leftJoin('t.attachments', 'a')
            ->andWhere('a IS NULL')
            ->andWhere('t.url IS NOT NULL')
            ->getQuery()
            ->getResult();

        $io->note(sprintf('Found %d tracks with URL', count($videoTracks)));

        foreach ($videoTracks as $track) {
            $attachment = new Attachment()
                ->setExtension('mp4')
                ->setKind('video')
                ->setTrack($track)
                ->setSize(0)
                ->setUrl($track->getUrl())
                ->setPreviewUrl($track->getPreviewUrl())
                ->setVideoEmbed($track->getVideoEmbed())
            ;

            $this->em->persist($attachment);
        }
        $this->em->flush();

        $io->success('Done');

        return Command::SUCCESS;
    }
}
