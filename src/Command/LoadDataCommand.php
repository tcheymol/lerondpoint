<?php

namespace App\Command;

use App\Domain\Track\TrackPersister;
use App\Entity\ActionKind;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[AsCommand(
    name: 'app:load-data',
    description: 'Load some necessary data',
)]
class LoadDataCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TrackPersister $trackPersister,
        private readonly string $kernelProjectDir,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->loadActionKinds();
        $this->loadTrackKinds();
        $this->loadUsers();
        $this->loadTracks();

        $this->em->flush();

        return Command::SUCCESS;
    }

    private function loadTrackKinds(): void
    {
        $this->emptyTable(TrackKind::class);

        $trackKinds = [
            'Appel', 'Tract', 'Chanson', 'Doléances', 'Poème', 'Rond-point', 'Manifestation', 'Péage', 'AdA', 'RIC',
            'Actions', 'Radar', 'Gilet jaune', 'Live', 'Film', 'Cabane', 'Goodies', 'Banderole', 'Monument', 'Livre'
        ];

        foreach ($trackKinds as $trackKind) {
            $trackKindEntity = (new TrackKind($trackKind));
            $this->em->persist($trackKindEntity);
        }
    }

    private function loadActionKinds(): void
    {
        $this->emptyTable(ActionKind::class);

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

    private function loadTracks(): void
    {
        $this->emptyTable(Track::class);

        $tracks = [
            ['name' => "L'assemblée des assemblées de Commercy", 'file' => 'adac.jpg'],
            ['name' => 'Appel de la première « assemblée des assemblées » des Gilets Jaunes', 'file' => 'aaagj.pdf'],
            ['name' => 'Appel des gilets jaunes de la maison du peuple de Saint Nazaire', 'file' => 'agj.mp4'],
            ['name' => 'Banderole Saint Nazaire', 'file' => 'banderole.jpg'],
            ['name' => 'Banderole Saint Nazaire 2', 'file' => 'banderole2.jpg'],
            ['name' => 'Calendrier Saint Nazaire', 'file' => 'calendrier.pdf'],
            ['name' => 'Chanson enfile ton gilet', 'file' => 'chanson.pdf'],
            ['name' => 'Cabane des gilets Jaune du rond-point Necker à Saint Etienne', 'file' => 'cabane.jpg'],
            ['name' => 'Témoignage mutilée Vanessa', 'file' => 'vanessa.png'],
            ['name' => 'Tract Acte X', 'file' => 'actex.pdf'],
        ];

        foreach ($tracks as $trackData) {
            $track = (new Track())->setName($trackData['name']);
            $originalFilePath = sprintf('%s/var/tracks_samples/%s', $this->kernelProjectDir, $trackData['file']);
            $tmpFilePath = sprintf('%s/var/tmp/%s', $this->kernelProjectDir, $trackData['file']);
            copy($originalFilePath, $tmpFilePath);
            $track->uploadedFile = new UploadedFile($tmpFilePath, $trackData['file']);
            $this->trackPersister->persist($track);
        }

        $this->em->flush();
    }

    private function loadUsers(): void {
        $this->emptyTable(User::class);

        $users = [
            't@g.c',
            'thibault@le-rondpoint.com',
            'djo@le-rondpoint.com',
            'adrien@le-rondpoint.com',
        ];

        foreach ($users as $user) {
            $user = (new User($user))->setRoles([ 'ROLE_ADMIN' ])->setPassword('$2y$13$vE36jFVY2JpvV8nMR9ccd.14MEdiNvBBSsL/UNoBYBsyx/FUSJh3q');
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    private function emptyTable(string $entityName): void {
        $this->em->createQuery(sprintf('DELETE %s e', $entityName))->execute();
    }
}
