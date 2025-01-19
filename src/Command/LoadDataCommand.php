<?php

namespace App\Command;

use App\Domain\Images\AttachmentHelper;
use App\Domain\Track\TrackPersister;
use App\Entity\Action;
use App\Entity\Attachment;
use App\Entity\Collective;
use App\Entity\Track;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[AsCommand(name: 'app:load-data', description: 'Load some necessary data')]
class LoadDataCommand extends Command
{
    public const array ENTITIES = [
        Action::class => [
            ['name' => "Animation d'un lieu", 'iconPath' => 'cabane'],
            ['name' => 'Rond-point', 'iconPath' => 'rondpoint'],
            ['name' => 'Autre', 'iconPath' => 'giletsjaunes'],
            ['name' => 'Réunion publique', 'iconPath' => 'reunionpublique'],
            ['name' => 'Politique locale', 'iconPath' => 'reunion'],
            ['name' => 'RIC', 'iconPath' => 'reunion'],
            ['name' => 'Éducation populaire', 'iconPath' => 'reunion'],
            ['name' => 'Jardin partagé', 'iconPath' => 'jardinpartage'],
            ['name' => 'Solidarité', 'iconPath' => 'solidarite'],
            ['name' => 'Manifestation', 'iconPath' => 'manifestation'],
            ['name' => 'Information/Média', 'iconPath' => 'journal'],
            ['name' => 'Tractage', 'iconPath' => 'reunionpublique'],

            ['name' => 'Animation', 'iconPath' => 'animation'],
            ['name' => 'Permanence', 'iconPath' => 'permanence'],
            ['name' => 'Distribution alimentaire', 'iconPath' => 'distributionalimentaire'],
            ['name' => 'Épicerie', 'iconPath' => 'epicerie'],
            ['name' => 'Radio', 'iconPath' => 'radio'],
            ['name' => 'Ressourcerie', 'iconPath' => 'ressourcerie'],
        ],
        TrackKind::class => [
            ['name' => 'AUDIO'],
            ['name' => 'TEXT'],
            ['name' => 'PHOTO-IMAGE'],
            ['name' => 'VIDEO'],
        ],
        TrackTag::class => [
            ['name' => 'Appel'],
            ['name' => 'Tract'],
            ['name' => 'Chanson'],
            ['name' => 'Doléances'],
            ['name' => 'Poème'],
            ['name' => 'Rond-point'],
            ['name' => 'Manifestation'],
            ['name' => 'Péage'],
            ['name' => 'AdA'],
            ['name' => 'RIC'],
            ['name' => 'Actions'],
            ['name' => 'Radar'],
            ['name' => 'Gilet jaune'],
            ['name' => 'Live'],
            ['name' => 'Film'],
            ['name' => 'Cabane'],
            ['name' => 'Goodies'],
            ['name' => 'Banderole'],
            ['name' => 'Monument'],
            ['name' => 'Livre'],
        ],
        User::class => [
            ['email' => 't@g.c'],
            ['email' => 'thibaut@le-rondpoint.com'],
            ['email' => 'djo@le-rondpoint.com'],
            ['email' => 'adrien@le-rondpoint.com'],
        ],
        Track::class => [
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
        ],
        Collective::class => [
            [
                'name' => 'Groupe Beliard',
                'lat' => '48.8958803',
                'lon' => '2.3330117',
                'address_line1' => '20 Rue Georgette Agutte',
                'city' => 'Paris',
                'country' => 'France',
                'postcode' => '75018',
                'state' => 'Ile-de-France',
            ],
        ],
    ];

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TrackPersister $trackPersister,
        private readonly string $kernelProjectDir,
        private readonly AttachmentHelper $attachmentHelper,
    ) {
        parent::__construct();
    }

    public function createAttachment(string $fileName): ?Attachment
    {
        $originalFilePath = sprintf('%s/var/tracks_samples/%s', $this->kernelProjectDir, $fileName);
        $tmpFilePath = sprintf('%s/var/tmp/%s', $this->kernelProjectDir, $fileName);
        copy($originalFilePath, $tmpFilePath);

        return $this->attachmentHelper->createAttachment(new UploadedFile($tmpFilePath, $fileName));
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->emptyTable(Attachment::class);

        $this->loadEntityData(TrackKind::class);
        $this->loadEntityData(TrackTag::class);

        $this->loadEntityData(User::class);
        $this->loadEntityData(Track::class);

        $this->loadEntityData(Collective::class);
        $this->loadEntityData(Action::class);

        return Command::SUCCESS;
    }

    /** @param array<string, string> $trackData */
    private function createTrack(array $trackData): Track
    {
        $track = (new Track())->setName($trackData['name']);
        $attachment = $this->createAttachment($trackData['file']);
        if ($attachment && $attachment->getId()) {
            $track->attachmentsIds[] = (string) $attachment->getId();
        }
        $this->trackPersister->persist($track);

        return $track;
    }

    private function emptyTable(string $entityName): void
    {
        $this->em->createQuery(sprintf('DELETE %s e', $entityName))->execute();
    }

    private function loadEntityData(string $entityName): void
    {
        var_dump('Loading data for '.$entityName);
        $this->emptyTable($entityName);
        $data = self::ENTITIES[$entityName];

        foreach ($data as $datum) {
            $entity = $this->createEntity($entityName, $datum);
            if ($entity) {
                $this->em->persist($entity);
            }
        }

        $this->em->flush();
    }

    /** @param array<string, string> $datum */
    private function createEntity(string $entityName, array $datum): ?object
    {
        return match ($entityName) {
            TrackKind::class => new TrackKind($datum['name']),
            TrackTag::class => new TrackTag($datum['name']),
            Action::class => new Action($datum['name'], $datum['iconPath']),
            Collective::class => $this->createCollective($datum),
            User::class => (new User($datum['email']))->setRoles(['ROLE_ADMIN'])->setPassword('$2y$13$vE36jFVY2JpvV8nMR9ccd.14MEdiNvBBSsL/UNoBYBsyx/FUSJh3q'),
            Track::class => $this->createTrack($datum),
            default => null,
        };
    }

    /** @param array<string, string> $datum */
    private function createCollective(array $datum): Collective
    {
        $owner = $this->em->getRepository(User::class)->findOneBy([]);

        return (new Collective($datum['name']))
            ->setLat((float) $datum['lat'])
            ->setLon((float) $datum['lon'])
            ->setAddressLine1($datum['address_line1'])
            ->setCity($datum['city'])
            ->setCountry($datum['country'])
            ->setPostcode($datum['postcode'])
            ->setState($datum['state']);
    }
}
