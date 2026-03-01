<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260301000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add position column to attachment table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE attachment ADD COLUMN position INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE attachment DROP COLUMN position');
    }
}
