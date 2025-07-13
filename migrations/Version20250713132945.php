<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713132945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__feature_toggle AS SELECT id, name, enabled FROM feature_toggle');
        $this->addSql('DROP TABLE feature_toggle');
        $this->addSql('CREATE TABLE feature_toggle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO feature_toggle (id, name, enabled) SELECT id, name, enabled FROM __temp__feature_toggle');
        $this->addSql('DROP TABLE __temp__feature_toggle');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__feature_toggle AS SELECT id, name, enabled FROM feature_toggle');
        $this->addSql('DROP TABLE feature_toggle');
        $this->addSql('CREATE TABLE feature_toggle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enabled BOOLEAN DEFAULT FALSE NOT NULL)');
        $this->addSql('INSERT INTO feature_toggle (id, name, enabled) SELECT id, name, enabled FROM __temp__feature_toggle');
        $this->addSql('DROP TABLE __temp__feature_toggle');
    }
}
