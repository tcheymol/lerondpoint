<?php

namespace App\Command;

use App\Entity\Action;
use App\Entity\RejectionCause;
use App\Entity\TrackKind;
use App\Entity\TrackTag;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:load-data', description: 'Load some necessary data')]
class LoadDataCommand extends Command
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
            ['name' => 'TEXT'],
            ['name' => 'IMAGE'],
            ['name' => 'VIDÉO'],
        ],
        TrackTag::class => [
            ['name' => 'Accessoire'],
            ['name' => 'Action'],
            ['name' => 'Assemblée'],
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
            ['email' => 't@g.c'],
            ['email' => 'thibaut.cheymol@protonmail.com'],
            ['email' => 'thibaut@le-rondpoint.com'],
            ['email' => 'djo@le-rondpoint.com'],
            ['email' => 'adrien@le-rondpoint.com'],
        ],
        RejectionCause::class => [
            ['name' => 'Contenu sans rapport avec le mouvement des Gilets jaunes'],
            ['name' => 'Contenu ne respectant pas les règles et les conditions d’utilisation du site'],
            ['name' => 'Contenu pouvant porter préjudice aux personnes'],
            ['name' => 'Contenu présentant un problème technique'],
            ['name' => 'Contenu incomplet'],
        ],
    ];

    public function __construct(private readonly EntityManagerInterface $em)
    {
        parent::__construct();
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion('Entité :', array_keys(self::ENTITIES), 0);
        $question->setErrorMessage('Option %s invalide.');

        $answer = $helper->ask($input, $output, $question);

        if (is_string($answer) && in_array($answer, array_keys(self::ENTITIES))) {
            $this->loadEntityData($answer, $io);

            return Command::SUCCESS;
        }

        $io->error('Entity not found');

        return Command::FAILURE;
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
            User::class => new User($datum['email'])->validateEmail()->setRoles(['ROLE_ADMIN'])->setPassword('$2y$13$vE36jFVY2JpvV8nMR9ccd.14MEdiNvBBSsL/UNoBYBsyx/FUSJh3q'),
            default => null,
        };
    }
}
