<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240831091042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment ADD COLUMN object_id BLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__attachment AS SELECT id, action_id, track_id, disabled_by_id, validated_by_id, path, extension, kind, size, created_at, updated_at, disabled, validated FROM attachment');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, action_id INTEGER DEFAULT NULL, track_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, path VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, disabled BOOLEAN NOT NULL, validated BOOLEAN NOT NULL, CONSTRAINT FK_795FD9BB9D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO attachment (id, action_id, track_id, disabled_by_id, validated_by_id, path, extension, kind, size, created_at, updated_at, disabled, validated) SELECT id, action_id, track_id, disabled_by_id, validated_by_id, path, extension, kind, size, created_at, updated_at, disabled, validated FROM __temp__attachment');
        $this->addSql('DROP TABLE __temp__attachment');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D32F035 ON attachment (action_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)');
    }
}
