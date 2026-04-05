<?php

namespace App\Command;

use App\Entity\Attachment;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\Region;
use App\Entity\Year;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:generate-fixtures', description: 'Generate fake tracks for dev/testing')]
readonly class GenerateFixturesCommand
{
    private const array NAMES = [
        'Rond-point de la Résistance', 'Manifestation pacifique', 'Cabane solidaire', 'Jardin partagé du quartier',
        'Rassemblement citoyen', 'Tract du mouvement', 'Témoignage d\'un gilet jaune', 'Assemblée populaire',
        'Banderole revendicative', 'Gilets jaunes en action', 'Solidarité locale', 'Péage gratuit',
        'RIC en marche', 'Animation de rue', 'Monument occupé', 'Musique de lutte',
        'Récit de groupe', 'Réunion publique ouverte', 'Poème du peuple', 'Film documentaire',
        'Graffiti citoyen', 'Goodies solidaires', 'Live depuis le rond-point', 'Appel à la mobilisation',
        'Doléances du village', 'Humour jaune', 'Imprimé militant', 'Livre blanc populaire',
        'Action directe', 'Éducation populaire en plein air', 'Tractage en ville', 'Politique locale participative',
        'Rassemblement festif', 'Occupation pacifique', 'Caravane citoyenne', 'Flash mob',
        'Veillée solidaire', 'Marche dans les rues', 'Blocage symbolique', 'Forum ouvert',
        'Repas partagé', 'Semaine de mobilisation', 'Mur des doléances', 'Fanfare militante',
        'Théâtre de rue', 'Atelier de fabrication', 'Balade militante', 'Pique-nique citoyen',
        'Exposition de rue', 'Concert de soutien',
    ];

    private const array LOCATIONS = [
        'Paris', 'Lyon', 'Marseille', 'Bordeaux', 'Toulouse', 'Nantes', 'Lille',
        'Strasbourg', 'Montpellier', 'Rennes', 'Grenoble', 'Nice', 'Rouen',
        'Toulon', 'Saint-Étienne', 'Dijon', 'Brest', 'Clermont-Ferrand', null, null,
    ];

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function __invoke(SymfonyStyle $io, #[Option] int $count = 100): int
    {
        $kinds = $this->em->getRepository(TrackKind::class)->findAll();
        $tags = $this->em->getRepository(TrackTag::class)->findAll();
        $regions = $this->em->getRepository(Region::class)->findAll();
        $years = $this->em->getRepository(Year::class)->findAll();

        $now = new \DateTimeImmutable();

        for ($i = 1; $i <= $count; ++$i) {
            $track = new Track();
            $track->setName(self::NAMES[($i - 1) % count(self::NAMES)].' #'.$i);
            $track->setDraft(false);
            $track->setValidated(true);
            $track->setRejected(false);
            $track->setLocation(self::LOCATIONS[array_rand(self::LOCATIONS)]);

            $daysAgo = (int) (($count - $i) * (365 / $count));
            $createdAt = $now->modify(sprintf('-%d days', $daysAgo));
            $track->setCreatedAt($createdAt);
            $track->setUpdatedAt($createdAt);

            if ($kinds) {
                $track->setKind($kinds[array_rand($kinds)]);
            }
            if ($tags) {
                $track->addTag($tags[array_rand($tags)]);
            }
            if ($regions) {
                $track->addRegion($regions[array_rand($regions)]);
            }
            if ($years) {
                $track->addYear($years[array_rand($years)]);
            }

            $attachment = new Attachment();
            $attachment->setExtension('jpg');
            $attachment->setKind('image/jpeg');
            $attachment->setSize(10000);
            $attachment->setPreviewUrl(sprintf('https://picsum.photos/seed/%d/400/300', $i));
            $attachment->setCreatedAt($createdAt);
            $attachment->setUpdatedAt($createdAt);

            $track->addAttachment($attachment);
            $this->em->persist($attachment);
            $this->em->persist($track);

            if (0 === $i % 20) {
                $this->em->flush();
                $io->text(sprintf('%d/%d tracks créées...', $i, $count));
            }
        }

        $this->em->flush();
        $io->success(sprintf('%d tracks générées.', $count));

        return Command::SUCCESS;
    }
}
