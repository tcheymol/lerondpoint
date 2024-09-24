<?php

namespace App\Command;

use App\Entity\ActionKind;
use App\Entity\TrackKind;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

        $this->em->flush();

        return Command::SUCCESS;
    }

    public function loadTrackKinds(): void
    {
        $trackKindsByFileType = [
            'audio' => ['Appel', 'Tract', 'Chanson', 'Doléances', 'Poème', 'Rond-point', 'Manifestation', 'Péage', 'AdA', 'RIC', 'Actions', 'Radar'],
            'text' => ['Film', 'Live', 'Appel', 'Tract', 'Chanson', 'Doléances', 'Poème', 'Cabane', 'Goodies', 'Gilet jaune', 'Banderole', 'Monument', 'Livre', 'Rond-point', 'Manifestation', 'Péage', 'AdA', 'RIC', 'Actions', 'Radar'],
            'image' => ['Appel', 'Tract', 'Chanson', 'Doléances', 'Poème', 'Gilet jaune', 'Livre', 'Rond-point', 'Manifestation', 'Péage', 'AdA', 'RIC', 'Actions', 'Radar'],
            'video' => ['Appel', 'Tract', 'Cabane', 'Goodies', 'Gilet jaune', 'Banderole', 'Monument', 'Rond-point', 'Manifestation', 'Péage', 'AdA', 'RIC', 'Actions', 'Radar'],
        ];

        foreach ($trackKindsByFileType as $fileType => $trackKinds) {
            foreach ($trackKinds as $trackKind) {
                $trackKindEntity = (new TrackKind($trackKind))->setFileTypes([$fileType]);
                $this->em->persist($trackKindEntity);
            }
        }
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
