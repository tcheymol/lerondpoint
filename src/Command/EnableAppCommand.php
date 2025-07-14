<?php

namespace App\Command;

use App\Entity\FeatureToggle;
use App\Repository\FeatureToggleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:enable-app', description: 'Enables app for public')]
readonly class EnableAppCommand
{
    public function __construct(private FeatureToggleRepository $repository, private EntityManagerInterface $em)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $featureToggle = $this->repository->findOneBy(['name' => 'website-online']);

        if (!$featureToggle) {
            $featureToggle = new FeatureToggle()->setName('website-online');
            $this->em->persist($featureToggle);
        }

        $featureToggle->setEnabled(true);
        $this->em->flush();

        return Command::SUCCESS;
    }
}
