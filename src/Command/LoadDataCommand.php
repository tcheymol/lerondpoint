<?php

namespace App\Command;

use App\Entity\ActionKind;
use App\Entity\TrackKind;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:load-data',
    description: 'Load some necessary data',
)]
class LoadDataCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->loadActionKinds();
        $this->loadTrackKinds();
        $this->loadLabels();
        $this->loadTracks();

        $this->em->flush();

        return Command::SUCCESS;
    }


    public function loadLabels(): void
    {

    }

    public function loadTrackKinds(): void
    {
        $trackKinds = [
            "TEXTE / Appel",
            "AUDIO / Chanson",
            "PHOTO / T-Shirt",
            "PHOTO / Banderole",
            "TEXTE / Tract - Appel",
            "VIDÉO / Documentaire",
        ];

        foreach ($trackKinds as $trackKind) {
            $trackKindEntity = new TrackKind($trackKind);
            $this->em->persist($trackKindEntity);
        }
    }

    public function loadTracks(): void
    {

    }

    public function loadActionKinds(): void
    {
        $actionKinds = [
            "Rassemblement et tractage sur un rond-point",
            "Cabane à proximité d'un rond-point ou d'une route",
            "Animation d'un lieu (exemples de bâtiment, hangar ou terrain) pour en faire un espace d'entraide, de réunion, d'éducation populaire (conférence gesticulée, concert, projection, etc.).",
            "Tractage ou tenue de stand dans l'espace public, action d'information vers la population (exemple : défense des services publics locaux)",
            "Réunion publique autour de questions de citoyenneté et de démocratie",
            "Jardin partagé",
            "Permanence administrative pour aider les personnes en situation de précarité",
            "Maraude",
            "Distribution alimentaire",
            "Participation aux mobilisations sociales/manifestations",
            "Gestion et animation d'une épicerie participative",
            "Animation d'une émission de radio",
            "Rédaction d'un journal local",
            "Animation d'un local type ressourcerie",
        ];

        foreach ($actionKinds as $actionKind) {
            $actionKindEntity = new ActionKind($actionKind);
            $this->em->persist($actionKindEntity);
        }
    }
}
