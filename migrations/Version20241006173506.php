<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241006173506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attachment ADD COLUMN height BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE attachment ADD COLUMN width BIGINT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__attachment AS SELECT id, extension, kind, size, object_id, thumbnail_object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM attachment');
        $this->addSql('DROP TABLE attachment');
        $this->addSql('CREATE TABLE attachment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, extension VARCHAR(255) NOT NULL, kind VARCHAR(255) DEFAULT NULL, size INTEGER NOT NULL, object_id VARCHAR(255) DEFAULT NULL, thumbnail_object_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, disabled BOOLEAN DEFAULT NULL, validated BOOLEAN DEFAULT NULL, action_id INTEGER DEFAULT NULL, track_id INTEGER DEFAULT NULL, created_by_id INTEGER DEFAULT NULL, updated_by_id INTEGER DEFAULT NULL, deleted_by_id INTEGER DEFAULT NULL, disabled_by_id INTEGER DEFAULT NULL, validated_by_id INTEGER DEFAULT NULL, CONSTRAINT FK_795FD9BB9D32F035 FOREIGN KEY (action_id) REFERENCES "action" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB5ED23C43 FOREIGN KEY (track_id) REFERENCES track (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BB1688BE50 FOREIGN KEY (disabled_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_795FD9BBC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO attachment (id, extension, kind, size, object_id, thumbnail_object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id) SELECT id, extension, kind, size, object_id, thumbnail_object_id, created_at, updated_at, deleted_at, disabled, validated, action_id, track_id, created_by_id, updated_by_id, deleted_by_id, disabled_by_id, validated_by_id FROM __temp__attachment');
        $this->addSql('DROP TABLE __temp__attachment');
        $this->addSql('CREATE INDEX IDX_795FD9BB9D32F035 ON attachment (action_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB5ED23C43 ON attachment (track_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBB03A8386 ON attachment (created_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB896DBBDE ON attachment (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC76F1F52 ON attachment (deleted_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BB1688BE50 ON attachment (disabled_by_id)');
        $this->addSql('CREATE INDEX IDX_795FD9BBC69DE5E5 ON attachment (validated_by_id)');
    }
}
