<?php

namespace App\Command;

use App\Entity\Action;
use App\Entity\Region;
use App\Entity\RejectionCause;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\User;
use App\Entity\Year;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:load-data', description: 'Load some necessary data')]
readonly class LoadDataCommand
{
    public const array ENTITIES = [
        Action::class => [
            ['name' => 'Rond-point', 'iconPath' => 'rondpoint'],
            ['name' => 'Solidarité', 'iconPath' => 'solidarite'],
            ['name' => "Animation d'un lieu", 'iconPath' => 'cabane'],
            ['name' => 'Jardin partagé', 'iconPath' => 'jardinpartage'],
            ['name' => 'Éducation populaire', 'iconPath' => 'animation'],
            ['name' => 'Manifestation', 'iconPath' => 'manifestation'],
            ['name' => 'Tractage', 'iconPath' => 'reunionpublique'],
            ['name' => 'RIC', 'iconPath' => 'reunion'],
            ['name' => 'Réunion publique', 'iconPath' => 'reunionpublique'],
            ['name' => 'Information/Média', 'iconPath' => 'journal'],
            ['name' => 'Politique locale', 'iconPath' => 'reunion'],
        ],
        TrackKind::class => [
            ['name' => 'AUDIO'],
            ['name' => 'TEXTE'],
            ['name' => 'IMAGE'],
            ['name' => 'VIDÉO'],
        ],
        TrackTag::class => [
            ['name' => 'Accessoire'],
            ['name' => 'Action'],
            ['name' => 'Assemblée'],
            ['name' => 'Anniversaire'],
            ['name' => 'Appel'],
            ['name' => 'Article'],
            ['name' => 'Arts plastiques'],
            ['name' => 'Banderole'],
            ['name' => 'Cabane'],
            ['name' => 'Doléances'],
            ['name' => 'Film'],
            ['name' => 'Gilet'],
            ['name' => 'Goodies'],
            ['name' => 'Graffiti'],
            ['name' => 'Humour'],
            ['name' => 'Imprimé'],
            ['name' => 'Jardin partagé'],
            ['name' => 'Live'],
            ['name' => 'Livre'],
            ['name' => 'Manifestation'],
            ['name' => 'Monument'],
            ['name' => 'Musique'],
            ['name' => 'Poème'],
            ['name' => 'Péage'],
            ['name' => 'Récit de groupe'],
            ['name' => 'Répression'],
            ['name' => 'RIC'],
            ['name' => 'Rond-point'],
            ['name' => 'Témoignage'],
            ['name' => 'Tract'],
        ],
        User::class => [
            ['email' => 'thibaut.cheymol@protonmail.com', 'role' => 'ROLE_ADMIN'],
            ['email' => 'thibaut.cheymol+user@protonmail.com', 'role' => 'ROLE_USER'],
            ['email' => 'thibaut.cheymol+modo@protonmail.com', 'role' => 'ROLE_MODERATOR'],
            ['email' => 'mil-an1871@protonmail.com', 'role' => 'ROLE_ADMIN'],
            ['email' => 'jo_vaudey@riseup.net', 'role' => 'ROLE_ADMIN'],
            ['email' => 'jo_vaudey+user@riseup.net', 'role' => 'ROLE_USER'],
            ['email' => 'jo_vaudey+modo@riseup.net', 'role' => 'ROLE_MODERATOR'],
            ['email' => 'sylvestre.meinzer@free.fr', 'role' => 'ROLE_MODERATOR'],
            ['email' => 'mathilde.fournols@outlook.fr', 'role' => 'ROLE_MODERATOR'],
        ],
        RejectionCause::class => [
            ['name' => 'Contenu sans rapport avec le mouvement des Gilets jaunes'],
            ['name' => 'Contenu ne respectant pas les règles et les conditions d’utilisation du site'],
            ['name' => 'Contenu pouvant porter préjudice aux personnes'],
            ['name' => 'Contenu présentant un problème technique'],
            ['name' => 'Contenu incomplet'],
        ],
        Year::class => [
            ['value' => '2018'],
            ['value' => '2019'],
            ['value' => '2020'],
            ['value' => '2021'],
            ['value' => '2022'],
            ['value' => '2023'],
            ['value' => '2024'],
            ['value' => '2025'],
        ],
        Region::class => [
            ['name' => 'Auvergne-Rhône-Alpes'],
            ['name' => 'Bourgogne-Franche-Comté'],
            ['name' => 'Bretagne'],
            ['name' => 'Centre-Val de Loire'],
            ['name' => 'Corse'],
            ['name' => 'Grand Est'],
            ['name' => 'Guadeloupe'],
            ['name' => 'Guyane'],
            ['name' => 'Hauts-de-France'],
            ['name' => 'Île-de-France'],
            ['name' => 'Martinique'],
            ['name' => 'Normandie'],
            ['name' => 'Nouvelle-Aquitaine'],
            ['name' => 'Occitanie'],
            ['name' => 'Pays de la Loire'],
            ['name' => "Provence-Alpes-Côte d'Azur"],
            ['name' => 'Réunion'],
            ['name' => "Autres territoires d'outre-mer"],
        ],
    ];

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function __invoke(SymfonyStyle $io, #[Option] bool $all = false): int
    {
        if ($all) {
            $entities = array_keys(self::ENTITIES);
        } else {
            $entity = $io->choice('Entité : ', array_keys(self::ENTITIES), 0);

            if (is_string($entity) && in_array($entity, array_keys(self::ENTITIES))) {
                $entities = [$entity];
            } else {
                $io->error('Entity not found');

                return Command::FAILURE;
            }
        }

        foreach ($entities as $entity) {
            $this->loadEntityData($entity, $io);
        }

        $io->success(sprintf('Entities loaded : %s', implode(', ', $entities)));

        return Command::SUCCESS;
    }

    private function emptyTable(string $entityName): void
    {
        $this->em->createQuery(sprintf('DELETE %s e', $entityName))->execute();
    }

    private function loadEntityData(string $entityName, SymfonyStyle $io): void
    {
        $io->info('Loading data for '.$entityName);
        $this->emptyTable($entityName);
        $data = self::ENTITIES[$entityName];

        foreach ($data as $datum) {
            $entity = $this->createEntity($entityName, $datum);
            $io->text(sprintf('Creating data: %s', reset($datum)));

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
            RejectionCause::class => new RejectionCause($datum['name']),
            Action::class => new Action($datum['name'], $datum['iconPath']),
            Region::class => new Region($datum['name']),
            Year::class => new Year((int) $datum['value']),
            User::class => new User($datum['email'])->validateEmail()->setRoles([$datum['role'] ?? 'ROLE_USER'])->setPassword('$2y$13$IEa5nGW/8ksoQJVK2JyDpeQpET2E9566CYzPsAFUOE0AcMDxG7IKW'),
            default => null,
        };
    }
}
