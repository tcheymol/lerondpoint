<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240905210218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE track ADD COLUMN lat DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE track ADD COLUMN lng DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__track AS SELECT id, collective_id, kind_id, disabled_by_id, validated_by_id, name, created_at, updated_at, disabled, validated FROM track');
        $this->addSql('DROP TABLE track');
        $this->addSql('CREATE TABLE track (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collective_id INTEGER NOT NULL, kind_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, disabled BOOLEAN NOT NULL, validated BOOLEAN NOT NULL, CONSTRAINT FK_D6E3F8A6EBB8240F FOREIGN KEY (collective_id) REFERENCES collective (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A630602CA9 FOREIGN KEY (kind_id) REFERENCES track_kind (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A61688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D6E3F8A6C69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO track (id, collective_id, kind_id, disabled_by_id, validated_by_id, name, created_at, updated_at, disabled, validated) SELECT id, collective_id, kind_id, disabled_by_id, validated_by_id, name, created_at, updated_at, disabled, validated FROM __temp__track');
        $this->addSql('DROP TABLE __temp__track');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6EBB8240F ON track (collective_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A630602CA9 ON track (kind_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61688BE50 ON track (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6C69DE5E5 ON track (validated_by_id)');
    }
}
